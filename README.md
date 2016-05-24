# nicRecord
##网络中心故障登记系统
- 实现了故障登记，查找，人员管理等功能。

- 支持数据库的模糊搜索

- 基于Bootstrap,支持响应式页面
 
- Dashboard使用了Chart.js展示数据

###各文件对应页面
---database/

------connectDB.php 连接数据库文件

---pages/

------action.php   功能文件login layout addRepair reset fix   adduser deleteuser

------add.php 登记故障页面

------detail.php 显示故障详情页

------list.php 显示故障列表

------login.php 登录页面

------main.php 主页面DashBoard仪表盘

------reset.html 用户修改密码页面

------resetuserinfo.php 修改用户信息页面

------search.php 查找页面

------usermanager.php 人员管理页面

------verificationCode.php 验证码生成页面
##数据库字段

 > 表的结构 `build`
 > 
`CREATE TABLE IF NOT EXISTS `build` (
  `build_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '建筑id',
  `build_name` varchar(30) NOT NULL COMMENT '建筑名称',
  `build_class` varchar(30) NOT NULL COMMENT '类别',
  PRIMARY KEY (`build_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;`

> 表的结构 `buildcount`
> 
`CREATE TABLE IF NOT EXISTS `buildcount` (
  `build_id` int(10) unsigned NOT NULL COMMENT '建筑id',
  `repair_count` int(10) unsigned NOT NULL COMMENT '数量',
  PRIMARY KEY (`build_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;`

>表的结构 `repair`
>
`CREATE TABLE IF NOT EXISTS `repair` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `repair_id` bigint(20) unsigned NOT NULL COMMENT '故障id',
  `user_id` bigint(15) unsigned NOT NULL COMMENT '维修人',
  `repair_time` int(10) unsigned NOT NULL COMMENT '维修时间',
  `build_id` int(10) unsigned NOT NULL COMMENT '建筑id',
  `room` varchar(20) NOT NULL COMMENT '房间号',
  `repair_describe` varchar(300) NOT NULL COMMENT '故障描述',
  `repair_cause` varchar(300) NOT NULL COMMENT '原因',
  `solution` varchar(300) NOT NULL COMMENT '解决方法',
  `note` varchar(300) NOT NULL COMMENT '心得',
  PRIMARY KEY (`id`),
  KEY `repair_id` (`repair_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;`

> 表的结构 `search`
> 
> `CREATE TABLE IF NOT EXISTS `search` (
  `repair_id` bigint(20) unsigned NOT NULL,
  `content` varchar(1000) NOT NULL,
  PRIMARY KEY (`repair_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;`

> 表的结构 `users`
> 
> `CREATE TABLE IF NOT EXISTS `users` (
  `uid` bigint(15) unsigned NOT NULL COMMENT '用户id',
  `username` varchar(30) NOT NULL COMMENT '用户名称',
  `password` varchar(200) NOT NULL COMMENT '密码',
  `weight` int(2) unsigned NOT NULL COMMENT '权重',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;`

> 表的结构 `weekcount`
> 
> `CREATE TABLE IF NOT EXISTS `weekcount` (
  `id` int(10) unsigned NOT NULL,
  `one` int(10) unsigned NOT NULL,
  `two` int(10) unsigned NOT NULL,
  `three` int(10) unsigned NOT NULL,
  `four` int(10) unsigned NOT NULL,
  `five` int(10) unsigned NOT NULL,
  `six` int(10) unsigned NOT NULL,
  `seven` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;`
***
##界面如下
![login](https://raw.githubusercontent.com/catkint/nicRecord/master/dist/image/login.png)
  ![dashboard](https://raw.githubusercontent.com/catkint/nicRecord/master/dist/image/dashboard.png)
