<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { TrendingUp, TrendingDown, Activity, ChevronRight } from 'lucide-vue-next';

const props = defineProps({
  tickers: {
    type: [Array, Object],
    default: () => [],
  },
});

const { locale } = useI18n();

const safeTickers = computed(() => {
  if (Array.isArray(props.tickers)) {
    return props.tickers.filter(t => t && typeof t === 'object' && t.symbol);
  }
  if (props.tickers && typeof props.tickers === 'object') {
    return Object.values(props.tickers).filter(t => t && typeof t === 'object' && t.symbol);
  }
  return [];
});

// Generate SVG smooth sparkline path + area fill
const getSparklinePath = (data, width = 64, height = 24) => {
  if (!Array.isArray(data) || data.length < 2) return { line: '', area: '' };
  const min = Math.min(...data);
  const max = Math.max(...data);
  const range = max - min || 1;
  const padding = 2;

  const points = data.map((val, idx) => {
    const x = (idx / (data.length - 1)) * width;
    const y = height - padding - ((val - min) / range) * (height - padding * 2);
    return { x, y };
  });

  const lineD = points.reduce((acc, pt, idx) => {
    return idx === 0 ? `M ${pt.x.toFixed(1)} ${pt.y.toFixed(1)}` : `${acc} L ${pt.x.toFixed(1)} ${pt.y.toFixed(1)}`;
  }, '');

  const areaD = `${lineD} L ${width} ${height} L 0 ${height} Z`;

  return { line: lineD, area: areaD };
};
</script>

<template>
  <div class="bg-[#0B0F19] text-[#E8EAF0] text-xs py-2.5 border-b border-[#232B3B] overflow-x-auto no-scrollbar font-mono">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between gap-6 whitespace-nowrap min-w-max">
      <!-- Bloomberg Terminal Tag -->
      <div class="flex items-center gap-2 text-[10px] uppercase font-bold tracking-widest text-zinc-400 border-r border-zinc-800 pr-5 flex-shrink-0">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span class="text-white font-sans font-black tracking-tight">MARKETS LIVE</span>
        <span class="text-[9px] text-zinc-500 hidden sm:inline">IST 17:30</span>
      </div>

      <!-- Tickers Stream -->
      <div class="flex items-center gap-6 sm:gap-8 flex-1">
        <div
          v-for="item in safeTickers"
          :key="item.symbol"
          class="flex items-center gap-3 py-0.5 group cursor-pointer hover:bg-zinc-900/60 px-2 rounded transition-colors"
        >
          <!-- Price & Change -->
          <div class="flex flex-col">
            <div class="flex items-center gap-2">
              <span class="font-bold text-white text-[11px] tracking-wide">{{ item.symbol }}</span>
              <span class="font-mono text-zinc-200 text-xs font-semibold">{{ item.price }}</span>
            </div>
            <div
              class="flex items-center gap-1 text-[11px] font-bold"
              :class="item.is_positive ? 'text-emerald-400' : 'text-rose-400'"
            >
              <TrendingUp v-if="item.is_positive" class="w-3 h-3 inline" />
              <TrendingDown v-else class="w-3 h-3 inline" />
              <span>{{ item.change }} ({{ item.percent_change }})</span>
            </div>
          </div>

          <!-- Mini Bloomberg SVG Sparkline Chart with Gradient Area Fill -->
          <svg
            v-if="item.sparkline && item.sparkline.length"
            class="w-16 h-6 overflow-visible"
            viewBox="0 0 64 24"
          >
            <defs>
              <linearGradient :id="`grad-${item.symbol}`" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" :stop-color="item.is_positive ? '#10B981' : '#F43F5E'" stop-opacity="0.25" />
                <stop offset="100%" :stop-color="item.is_positive ? '#10B981' : '#F43F5E'" stop-opacity="0.0" />
              </linearGradient>
            </defs>

            <!-- Area under line -->
            <path
              :d="getSparklinePath(item.sparkline).area"
              :fill="`url(#grad-${item.symbol})`"
            />

            <!-- Sparkline Stroke -->
            <path
              :d="getSparklinePath(item.sparkline).line"
              fill="none"
              :stroke="item.is_positive ? '#10B981' : '#F43F5E'"
              stroke-width="1.75"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </div>
      </div>

      <!-- Right Financial Summary pill -->
      <div class="hidden xl:flex items-center gap-2 text-[10px] text-zinc-400 border-l border-zinc-800 pl-4 flex-shrink-0">
        <Activity class="w-3.5 h-3.5 text-emerald-400" />
        <span>BSE/NSE OPEN</span>
      </div>
    </div>
  </div>
</template>
