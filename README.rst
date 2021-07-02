handbook-tool
=============================
handbook-tool，是PHP开发的一个简易的web端用户手册编写工具。

demo
------------------------
手册编辑入口： http://handbook-demo.licy.top （密钥: licy.top）
手册阅读入口: http://handbook-demo.licy.top/handbook

体验一下
-------------------------

* 先通过git拉取代码
    git clone https://github.com/asbamboo/handbook-tool.git
* 进到代码的根目录
    cd handbook-tool
* 创建配置文件
    vi config.php
    
    文件的内容如下
    
    ::

        <?php
        if(!isset($GLOBALS['ENTRANCE'])){ exit('Get out'); }
        return [
            'HANDBOOK_ROOT'       => __DIR__ . '/handbook', // 生成手册存放的目录
            'HANDBOOK_LOGO'       => __DIR__ . '/handbook/image/logo.png', // logo图片, 可以不设置
            'HANDBOOK_TITLE'      => '文档中心', // 文档标题
            'HANDBOOK_SECRET_KEY' => '1213', // 编辑修改文需要输入这个秘钥
            'HANDBOOK_IS_SYMLINK' => false, // 控制文档关联的资源文件使用复制（copy）还是快捷（link）方式。
        ];
* 试运行
    php -S 127.0.0.1:8000
