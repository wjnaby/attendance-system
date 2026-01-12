import './bootstrap';
import { createApp } from 'vue';

// Import Vue Components
import QrScanner from './components/QrScanner.vue';
import AttendanceChart from './components/AttendanceChart.vue';

const app = createApp({});

app.component('qr-scanner', QrScanner);
app.component('attendance-chart', AttendanceChart);

app.mount('#app');