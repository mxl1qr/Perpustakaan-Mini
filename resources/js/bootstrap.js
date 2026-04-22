import axios from 'axios';
window.axios = axios;

window.axios.defaults.header.common['X-Requested-With'] = 'XMLHttpRequest';