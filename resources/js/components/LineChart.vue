<script>
import { defineComponent } from 'vue'
import { Line } from 'vue3-chart-v2'

export default defineComponent({
  name: 'MonthlyChart',
  extends: Line,
  props:{
    chartData:{
        type: Object,
        required: true
    },
    chartOption:{
        type: Object,
        required: true
    },
    update:{
        type:Number
    }
  },
  mounted () {
    this.renderChart(this.chartOption, this.chartData);
  },
  watch:{
    update:{
        handle: function(){
            this._chart.destroy();
            this.renderChart(this.chartOption, this.chartData);
        }
    }
  }
})
</script>