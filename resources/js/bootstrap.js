import axios from 'axios';
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';
window.axios = axios;
window.Cropper = Cropper;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
