var $ = {
	ajax: function (obj) {
		var url = obj.url || location.pathname;
		var type = obj.type || 'get';
		var success = obj.success || function () {};
		var data = obj.data || {};
		function change (arg) {
			var s = '';
			for (var k in arg) {
				s += k + "=" + arg[k] + "&";
			}
			return s.slice(0, -1);
		}
		data = change(data);
		// 验证加不加括号是否都可以
		var xhr = new XMLHttpRequest;
		if (type == "get") {
			url = url + "?" + data;
			data= null;
		}
		xhr.open(type, url);
		if (type == "post") {
			xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		}
		
		xhr.send(data);
		xhr.addEventListener("readystatechange",function () {
			if (xhr.status == 200 && xhr.readyState == 4) {
				success(JSON.parse(xhr.responseText));
			}
		});
	}

}