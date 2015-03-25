/**
 * Создаем приложение angular
 */
var app = angular
	.module('app', [
		'ngRoute'
		, 'ngResource'
		, 'ngStorage'
		// my own modules and services
		, 'templates'
		, 'app.controllers'
		, 'app.chatApi'
	]);

/**
 * Конфигурируем приложение
 **/
app.config(['$routeProvider', '$locationProvider', '$httpProvider', function($routeProvider, $locationProvider, $httpProvider) {
	$routeProvider
		.when('/chat', {
			templateUrl: 'chat/chat.html',
			controller: 'ChatCtrl'
		})
		.when('/login', {
			templateUrl: 'chat/login.html',
			controller: 'LoginCtrl'
		})
		.otherwise({
			redirectTo: '/login'
		});

	// Без хэштега
	$locationProvider.html5Mode({
		enabled: true,
		requireBase: false
	});

	$httpProvider.interceptors.push(['$q', '$location', '$localStorage', function($q, $location, $localStorage) {
		return {
			'request': function (config) {
				config.headers = config.headers || {};
				if ($localStorage.token) {
					config.headers.Authorization = 'Bearer ' + $localStorage.token;
				}
				return config;
			},
			'responseError': function(response) {
				if(response.status === 401 || response.status === 403) {
					$location.path('/login');
				}

				return $q.reject(response);
			}
		};
	}]);

}]);

// Объявим модуль для кэша шаблонов в один файл и приклеивания его (см gulpfile.js)
angular.module('templates', []);