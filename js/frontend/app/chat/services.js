(function(window, $, _) {
	var ChatApi = angular.module('app.services', ['ngResource']);

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

})(window, $, _);
