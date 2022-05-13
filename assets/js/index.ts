// Node modules
import 'bootstrap';
import 'htmx.org';
import 'unpoly';

// Pages
import './pages/login';
import './pages/register';
import './pages/profile';
import './pages/forum';
import './pages/admin';
import './pages/pagebuilder';
import './pages/edit-article';

// Components
import './components/header';
import './components/footer';
import './components/alert';

// Tiles
import './tiles/new-article';
import './tiles/new-page';
import './tiles/new-tile';

// @ts-ignore
window.htmx = require('htmx.org');

// Images
// @ts-ignore
import Favicon from '../svg/icons/favicon.svg';

new Image(Favicon);