<template>
    <div class="chart-container">
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>

<script>
export default {
    name: 'AttendanceChart',
    props: {
        present: {
            type: Number,
            required: true,
        },
        late: {
            type: Number,
            required: true,
        },
        absent: {
            type: Number,
            required: true,
        },
    },
    mounted() {
        this.renderChart();
    },
    methods: {
        renderChart() {
            const canvas = this.$refs.chartCanvas;
            const ctx = canvas.getContext('2d');
            
            const total = this.present + this.late + this.absent;
            if (total === 0) {
                ctx.font = '16px Arial';
                ctx.fillStyle = '#666';
                ctx.textAlign = 'center';
                ctx.fillText('No data available', canvas.width / 2, canvas.height / 2);
                return;
            }
            
            // Simple bar chart
            const barWidth = 80;
            const spacing = 60;
            const maxHeight = 200;
            const maxValue = Math.max(this.present, this.late, this.absent);
            
            const data = [
                { label: 'Present', value: this.present, color: '#10b981' },
                { label: 'Late', value: this.late, color: '#f59e0b' },
                { label: 'Absent', value: this.absent, color: '#ef4444' },
            ];
            
            canvas.width = (barWidth + spacing) * 3 + spacing;
            canvas.height = maxHeight + 100;
            
            data.forEach((item, index) => {
                const x = spacing + (barWidth + spacing) * index;
                const barHeight = (item.value / maxValue) * maxHeight;
                const y = canvas.height - barHeight - 50;
                
                // Draw bar
                ctx.fillStyle = item.color;
                ctx.fillRect(x, y, barWidth, barHeight);
                
                // Draw value
                ctx.fillStyle = '#333';
                ctx.font = 'bold 20px Arial';
                ctx.textAlign = 'center';
                ctx.fillText(item.value, x + barWidth / 2, y - 10);
                
                // Draw label
                ctx.font = '14px Arial';
                ctx.fillText(item.label, x + barWidth / 2, canvas.height - 20);
            });
        },
    },
};
</script>

<style scoped>
.chart-container {
    display: flex;
    justify-content: center;
    padding: 20px;
}
</style>