/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// bootstrap select
require('bootstrap-select/dist/js/bootstrap-select.min');

// require('cleave.js/dist/cleave.min');
// require('cleave.js/dist/addons/cleave-phone.bd');

import moment from 'moment';

// Moment.js
// Parse, validate, manipulate, and display dates and times in JavaScript.
window.moment = moment;

let momentDateTime;
const momentDateTimeUpdate = function() {
	momentDateTime.html(moment().format('Do MMMM YYYY, hh:mm:ss A'));
};

$(document).ready(() => {
	momentDateTime = $('.moment-datetime');
	momentDateTimeUpdate();
	setInterval(momentDateTimeUpdate, 1000);
});

require('parsleyjs');

require('pretty-checkbox');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

/* const files = require.context('./', true, /\.vue$/i);
files.keys().map(key =>
	Vue.component(
		key
			.split('/')
			.pop()
			.split('.')[0],
		files(key).default
	)
);*/

// Vue.component('comment-component', require('./components/Comment.vue').default);

/* const app = new Vue({
	el: '#app'
});*/

import Vue from 'vue/dist/vue.min';
window.Vue = Vue;
