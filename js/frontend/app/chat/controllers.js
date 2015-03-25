(function() {
	angular.module('app.controllers', [])
		.controller('ChatCtrl', ["$scope", 'messagesList', function($scope, messagesList) {
			var defaultMessage = {
				text: ""
			};

			/**
			 * Модель связанна с текущим сообщением
			 */
			$scope.message = angular.copy(defaultMessage);

			/**
			 * Лист сообщений
			 */
			$scope.messagesList = messagesList;

			/**
			 * Отправка сообщения на сервер
			 * @param msg
			 */
			$scope.sendMessage = function(msg) {
				console.dir(msg.text);
				$scope.resetMessage();
			};

			/**
			 * Ресет текущей модели сообщения
			 */
			$scope.resetMessage = function() {
				$scope.message = angular.copy(defaultMessage);
			}
		}]);

	angular.module('app.controllers')
		.controller('LoginCtrl', ['$scope', '$location', '$localStorage', 'User', function($scope, $location, $localStorage, User) {
			// Если есть токен, то просто редиректим на страницу чата
			if ($localStorage.token) {
				//$location.path('/chat');
			}
			$scope.loginUser = User;
			$scope.formError = null;

			/**
			 * Функция входа на сайт
			 */
			$scope.login = function() {
				$scope.loginUser
					.getToken()
					.then(function(res) {
						$localStorage.token = res.token;
						$location.path('/chat');
					}, function(errRes) {
						$scope.formError = errRes.data.err;
						$location.path('/login');
					});
			}
		}])
})();