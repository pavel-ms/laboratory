/**
 * Создаем приложение angular
 */
var app = angular
	.module('app', [
		'ngRoute'
		, 'ngResource'
		// my own modules and services
		, 'templates'
		, 'app.controllers'
		, 'app.services'
	]);

/**
 * Конфигурируем роутер
 **/
app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
	$routeProvider
		.when('/chat', {
			templateUrl: 'chat/chat.html',
			controller: 'ChatCtrl'
		})
		.otherwise({
			redirectTo: '/chat'
		});

	// Без хэштега
	$locationProvider.html5Mode({
		enabled: true,
		requireBase: false
	});

}]);

// Объявим модуль для кэша шаблонов в один файл и приклеивания его (см gulpfile.js)
angular.module('templates', []);