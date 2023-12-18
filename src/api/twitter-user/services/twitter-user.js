'use strict';

/**
 * twitter-user service
 */

const { createCoreService } = require('@strapi/strapi').factories;

module.exports = createCoreService('api::twitter-user.twitter-user');
