// Node modules
import 'bootstrap';
import 'htmx.org';
import 'unpoly';

// Other assets
import './lib/navigation';
import './lib/login';
import './lib/register';
import './lib/profile';
import './lib/forum';
import './lib/admin';
import './lib/pagebuilder';
import './lib/footer';
import './components/alert';
import './tiles/new-article';
import './tiles/new-page';
import './tiles/new-tile';

// @ts-ignore
window.htmx = require('htmx.org');

// Images
// @ts-ignore
import Favicon from '../img/icons/favicon.png';

new Image(Favicon);