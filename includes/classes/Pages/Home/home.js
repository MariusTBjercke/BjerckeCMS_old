import Plyr from 'plyr';
import {DOMReady} from "@assets/js/shared/domready";

DOMReady(() => {
    const plyr = new Plyr('#player', {
        controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen'],
        settings: ['captions', 'quality', 'speed', 'loop']
    });
});