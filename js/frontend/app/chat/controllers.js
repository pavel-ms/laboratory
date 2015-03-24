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
})();

