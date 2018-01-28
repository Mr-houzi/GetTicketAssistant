# GetTicketAssistan 微信小程序领票小助手

![](https://img.shields.io/badge/language-javascript-orange.svg)&nbsp;
![](https://img.shields.io/badge/language-php-green.svg)&nbsp;
![](https://img.shields.io/badge/release-v2.1-blue.svg)

## Contents 目录
- [Introduction 介绍](#Introduction)
- [Use 使用](#Use)
- [Version 版本](#Version)
- [Construction 项目结构](#Construction)
- [UI 界面](#UI)
- [To optimize 待优化](#To)
- [Explain 说明](#Explain)

<a name="Introduction"></a>
## Introduction 介绍
领票小助手，是一款在线领取二维码门票的微信小程序。用户可以通过绑定的微信公众号或者搜索小程序名等方式进入领票小助手。通过此软件用户可以在线领取二维码形式的电子门票（二维码即门票）。晚会或者活动前，用户出示二维码门票给工作人员，工作人员扫码进行检票。检票成功后，用户可进入场馆，参加晚会或者活动。

此项目为领票系统，检票系统，在稍后开源。

<a name="Use"></a>
## Use 使用
### 安装 
使用wafer一站式服务器或者自己搭建小程序服务器

### 技术 
后端使用PHP语言完成，运用了Thinkphp3.2框架

<a name="Version"></a>
## Version 版本
当前版本v2.1

<a name="Construction"></a>
## Construction 项目结构
--client  小程序端

--server  服务器端

--data  数据库文件 

--project.config.json  小程序配置文件

--README.md  文档

<a name="UI"></a>
## UI 界面
代码写的差不要紧，界面写的丑也不要紧，强行P一下效果图，掩饰一波尴尬￣□￣｜｜

![](https://github.com/Mr-houzi/GetTicketAssistant/blob/master/doc/UI-render.jpg)

<a name="To"></a>
## To optimize 待优化
1.采用MD5加密座号代码code

2.优化多人领票UI
每前端点击+号，增加一人身份验证输入框

3.优化门票生成算法

4.处理高并发

<a name="Explain"></a>
## Explain 说明
此系统是我为学校新年晚会开发的在线领票系统，开发时间紧张，由很多不足之处，如果有兴趣的朋友，欢迎来一起PR。

联系邮箱：ghosthouzi@foxmail.com