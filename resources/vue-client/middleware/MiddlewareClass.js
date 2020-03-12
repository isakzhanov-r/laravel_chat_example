'use strict';

import MiddlewareConfig from './MiddlewareConfig';

class MiddlewareClass {

    constructor() {
        this.middlewares = [];
    }

    use(middleware) {

        if (Array.isArray(middleware)) {
            this.middlewares.push(...middleware);
        }
        if (typeof middleware === 'string') {
            this.middlewares.push(middleware);
        }

        return this;
    }

    callMiddleware(to, from, next) {
        const _next = (...args) => {

            const stack = this.middlewares.reverse();
            if (args.length > 0 || stack.length === 0) {
                return next(...args);
            }

            const middleware = stack.pop();

            if (middleware in MiddlewareConfig) {
                MiddlewareConfig[middleware](to, from, _next,middleware);
            } else {
                throw Error(`Undefined middleware [${middleware}]`);
            }
        };

        _next();

    }

}

export default MiddlewareClass;
