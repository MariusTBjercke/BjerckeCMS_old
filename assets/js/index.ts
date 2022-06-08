// Node modules
import 'bootstrap';

// Pages
import '@pages/Login/login';
import '@pages/Register/register';
import '@pages/Profile/profile';
import '@pages/Forum/forum';
import '@pages/Admin/admin';
import '@pages/PageBuilder/pagebuilder';
import '@pages/Admin/EditArticle/editarticle';
import '@pages/Home/home';

// Components
import '@assets/js/components/header';
import '@assets/js/components/footer';
import '@assets/js/components/alert';

// Tiles
import '@tiles/Articles/New/newarticle';
import '@tiles/Tools/NewPage/newpage';
import '@tiles/Tools/NewTile/newtile';

// Shared
import './shared/preload';

// Images
import Favicon from '../svg/icons/favicon.svg';

new Image(Favicon);