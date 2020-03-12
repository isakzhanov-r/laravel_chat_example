'use strict';

import auth from './modules/Authenticate';
import guest from './modules/RedirectIfAuthenticated';
import check from './modules/Check';


export default {
    auth,
    guest,
    check
};
