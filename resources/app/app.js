import "./app.css";
import Alpine from "alpinejs";
import FireLine from "fireline";

Alpine.plugin(FireLine);

Object.assign(window.FireLine.settings, {
  targetEl: "#app > div",
  focusOnError: true,
  progressBar: true,
  progressColor: "#1a1a1a",
});

document.addEventListener("fireNavigate", () => {
  // Move keyboard and screen-reader focus to the newly rendered page.
  document.querySelector("[data-page-heading]")?.focus({ preventScroll: true });
});

window.Alpine = Alpine;
Alpine.start();
