/**
 * Created by JQ on 2017/8/27.
 */
// ����һ����ʱ����ҳ�汳���任�����ɫ
timer = setInterval(function () {
    var arr = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f"];
    var randomColor = "#";
    for (var i = 0; i < 6; i++) {
        var index = parseInt(Math.random() * 16);
        randomColor += arr[index];
    }
    document.body.bgColor = randomColor;
}, 3000);
// �������ķ�ʽд��ק����
(function () {  // �հ���ʽ
    function Drag (id) {
        // ����ǰ��ʽ����this�Ϲ�һ�����ԣ���������Ե�����ק����
        this.obj = document.getElementById(id);
        this.x = 0;
        this.y = 0;
    }
    // һ������ԭ����дһ����ʼ���������������������ݽ��г�ʼ������
    Drag.prototype.init = function () {
        var that = this;
        this.obj.onmousedown = function (e) {
            e = e || event;
            that.x = e.clientX - this.offsetLeft;
            that.y = e.clientY - this.offsetTop;

            document.onmousemove = function (e) {
                that.fnMove(e);
            }
            document.onmouseup = that.fnUp;
        }
    }
    Drag.prototype.fnMove = function (e) {
        var e = e || event;
        this.obj.style.left = e.clientX - this.x + "px";
        this.obj.style.top = e.clientY - this.y + "px";
    }
    Drag.prototype.fnUp = function () {
        document.onmousemove = document.onmouseup = null;
    }
    window.Drag = Drag;
    // �������ȫ�ֱ�������������Ϊ���캯����this�����Դ���
    // ����ʵ����������¼��͹��ܾ����ܻ��ֵ�ϸһЩ����������
    // ע��this �����⣬ע��thisָ��������⣬����취����this�ı�ǰ��that�洢һ��
})();
