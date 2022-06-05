// Node modules
import 'bootstrap';

// Pages
import './pages/login';
import './pages/register';
import './pages/profile';
import './pages/forum';
import './pages/admin';
import './pages/pagebuilder';
import '@pages/Admin/EditArticle/editarticle';

// Components
import './components/header';
import './components/footer';
import './components/alert';

// Tiles
import '@tiles/Articles/New/newarticle';
import '@tiles/Tools/NewPage/newpage';
import '@tiles/Tools/NewTile/newtile';

// Shared
import './shared/preload';

// Images
import Favicon from '../svg/icons/favicon.svg';

new Image(Favicon);