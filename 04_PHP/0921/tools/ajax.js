// 如果使用普通方式传参，不方便设置默认参数，严格按照顺序取数据
// function ajax1 (url, type, data) {

// }

// 对象的方式传递参数，不受参数顺序影响，较灵活
// function ajax2 (obj) {
// 	var url = obj.url;
// 	var type = obj.type;
// 	var data = obj.data;
// }
// 避免全局污染，ajax方法没有暴露在全局下,为合格函数传递一个对象形式的参数，解决参数顺序的问题
var $ = {
	ajax: function (obj) {
		// 参数的处理
		var url = obj.url || location.pathname;
		var type = obj.type || "get";
		var data = obj.data || {};
		// 转成key=value的格式，为了方便使用
		function params (arg) {
			var s = '';
			for (var key in arg) {
				s += key + '=' + arg[key] + '&';
			}
			return s.slice(0, -1);
		}
		data = params(data);
		var success = obj.success || function () {};

		var xhr = new XMLHttpRequest;
		// 根据请求方式对data处理   send时候的逻辑处理
		if (type == 'get') {
			url = url + '?' + data;
			data = null;
		}

		xhr.open(type, url);

		if (type == "post") {
			xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		}
		xhr.send(data);
		// 不同的请求实现不同的逻辑处理  (回调函数)  前端写好不同的函数挂在对象上
		xhr.addEventListener("readystatechange", function () {
			if (xhr.status == 200 && xhr.readyState == 4) {
				success(JSON.parse(xhr.responseText));
			}
		});
	}
};