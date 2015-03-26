(function(window, $, _) {
	var ChatApi = angular.module('app.chatApi', ['ngResource']);

	ChatApi.factory('messagesList', ['$resource', function($resource) {
		//return $resource();
		// Пока возвращаем просто тестовые сообщения
		return [
			{
				id: 1
				, date: '24.03.2015'
				, text: 'test message 1'
				, user: 'User Name'
			}
			, {
				id: 2
				, date: '24.03.2015'
				, text: 'test message 2'
				, user: 'User Name'
			}
		];
	}]);

	/**
	 * Сервис взаимодействия с пользователем
	 */
	var authSrv = null;
	ChatApi.factory('AuthService', ['$resource', function($resource) {
		if (authSrv) {
			return authSrv;
		}
		// ресурс работы с API
		var authService = $resource('auth/get-token', {}, {
			getToken: {
				method: 'POST'
			}
		});

		var Mod = function() {};
		Mod.prototype = {
			login: null,
			password: null,

			getToken: function() {
				var self = this;
				return authService.getToken({}, {
					login: self.login
					, password: self.password
				}).$promise;
			}
		};

		var authSrv = new Mod();

		return authSrv;
	}]);

})(window, $, _);
