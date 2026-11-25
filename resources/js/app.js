

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Dispatch alpine:init event so template listeners can register data/components
document.dispatchEvent(new CustomEvent('alpine:init'));

Alpine.start();
