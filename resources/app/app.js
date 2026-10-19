import "./app.css";

import Alpine from "alpinejs";
import FireLine from "fireline";
import axios from "axios";

window.Alpine = Alpine;

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// Register FireLine plugin with Alpine
Alpine.plugin(FireLine);

// Start Alpine
Alpine.start();
