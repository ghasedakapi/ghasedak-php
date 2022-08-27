
<!-- PROJECT LOGO -->  
<br />  
<p align="center">  
  <a href="https://github.com/ghasedakapi/ghasedak-php">  
    <img src="g4php.png" alt="Logo" height="200" alt="ghasedak for php">  
  </a>  
  
  <h3 align="center">Ghasedak PHP SDK</h3>  
  
  <p align="center">  
    Easy-to-use SDK for implementing Ghasedak SMS API in your PHP projects.  
    <br />  
    <a href="https://ghasedak.me/php"><strong>Explore the docs »</strong></a>  
    <br />  
    <br />  
    <a href="https://ghasedak.me/developers">Web Service Documents</a>  
    ·  
    <a href="https://ghasedak.me/docs">REST API</a>  
    .  
    <a href="https://github.com/ghasedakapi/ghasedak-php/issues">Report Bug</a>  
    ·  
    <a href="https://github.com/ghasedakapi/ghasedak-php/issues">Request Feature</a>  
  </p>  
</p>  
  
<br>  
<p align="center">
	<a href="https://github.com/ghasedakapi/ghasedak-php/graphs/contributors"><img src="https://img.shields.io/github/contributors/ghasedakapi/ghasedak-php.svg" alt="contributors"></a>
	<a href="https://github.com/ghasedakapi/ghasedak-php/network/members"><img src="https://img.shields.io/github/forks/ghasedakapi/ghasedak-php.svg" alt="forks"></a>
	<a href="https://github.com/ghasedakapi/ghasedak-php/stargazers"><img src="https://img.shields.io/github/stars/ghasedakapi/ghasedak-php.svg" alt="stars"></a>
	<a href="https://github.com/ghasedakapi/ghasedak-php/issues"><img src="https://img.shields.io/github/issues/ghasedakapi/ghasedak-php.svg" alt="issues"></a>
	<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="license"></a>
</p>
  
<p align="center">  
    <a href="#table-of-contents">English Document</a> | <a href="#table-of-contents-fa">مستندات فارسی</a>  
</p>  
  
<!-- TABLE OF CONTENTS -->  
## Table of Contents  
  
* [Install](#install)
* [Usage](#usage)  
  * [Parameters](#parameters)  
  * [Example](#example)  
* [One-Time Passwords (OTP)](#one-time-passwords-otp)  
  * [Parameters](#parameters-1)  
  * [Example](#example-1)  
* [Licence](#license)  
  
## Install  
  
The easiest way to install is by using [Composer](https://getcomposer.org/):  
  
```sh  
composer require ghasedak/php  
```  
Composer is a dependency manager for PHP which allows you to declare the libraries your project depends on, and it will manage (install/update) them for you.  If you are not familiar with Composer, you can read its documentations and download it via [getcomposer.org](https://getcomposer.org/).

Alternatively you can download Ghasedak SDK from [here](https://github.com/ghasedakapi/ghasedak-php/archive/master.zip) and extract it in your project and follow the rest of the instructions below. Also there is an `Example` folder inside the package which you can use to understand the procedure.
## usage  
    
To use the API, you need an API key. To get that you should have a [Ghasedak](https://ghasedak.me) account. Register and get your API key.  
  
Then require the file autoload.php to get all classes and dependencies loaded.  
```php  
require __DIR__ . '/vendor/autoload.php';
```  
  
Create an instance from Ghasedak class with your API key:  
  
```php  
$api = new \Ghasedak\GhasedakApi( 'your_api_key');  
```  
Don't forget to change `your_api_key` with the key you have got from your Ghasedak account.


Send a sms:  
```php  
$api->SendSimple(  
 "09xxxxxxxxx", // receptor
 "Hello World!", // message
 "3000xxxxx" // choose a line number from your account
);  
```  
  
## Parameters  
| Parameter | Required | Description | Type | Example |  
| --- | --- | --- | --- | --- |  
| message | Yes | Text to be sent | string | Hello, World! |  
| receptor |  Yes | The number of the recipient(s) of the message (seperated by comma `,`). | string | 09111111111 |  
| linenumber | No | The number of the sender of the message, which, if not specified, will be selected from your dedicated lines with a higher priority.**```(If you do not have a dedicated line, you must specify the linenumber)```** | string | 5000222 |  
| senddate | No | The exact date and time of sending the message based on Unix time, if not specified, the message will be sent instantly. | string | 1508144471 |  
| checkid | No | It is used to set a unique number for each SMS, and after sending the SMS, all the information of the sent message can be received with the `status` method. | string | 2071 |  
  
## Example  
Here is a sample code for sending SMS. Please note that you must specify `linenumber` if you don't have a dedicated line.  
```php  
require __DIR__ . '/vendor/autoload.php';
 
try{  
 $message = "Hello, World!";
 $lineNumber = null; // If you do not have a dedicated line, you must specify the line number  
 $receptor = "09xxxxxxxxx";
 $api = new \Ghasedak\GhasedakApi('api_key');
 $api->SendSimple($receptor,$message,$lineNumber);  
}
catch(\Ghasedak\Exceptions\ApiException $e){  
 echo $e->errorMessage();  
}  
catch(\Ghasedak\Exceptions\HttpException $e){  
 echo $e->errorMessage();  
}  
```  
  
## One-Time Passwords (OTP)
The One-Time-Password (OTP) Interface is used to perform a mobile authentication or to implement Two-Factor-Authentication (2FA).  
You can pass up to 10 `param` to `Verify` method;  
```php  
$api->setVerifyType(GhasedakApi::VERIFY_TEXT_TYPE)->Verify(  
 "09xxxxxxxxx",  // receptor
 "my-template",  // name of the template which you've created in you account 
 "param1",       // parameters (supporting up to 10 parameters) 
 "param2", 
 "param3");
 ```  
  
## Parameters  
| Parameter | Required | Description | Type | Example |  
| --- | --- | --- | --- | --- |  
| receptor |  Yes | The number of the recipient of the message. | string | 09111111111 |  
| type | Yes | Set `1` to send text message and `2` to send voice message. | int | Hello, World! |  
| template | Yes | The title of the template you created in your panel. | string | my-template |  
| checkid | No | It is used to set a unique number for each SMS, and after sending the SMS, all the information of the sent message can be received with the `status` method. | string | 2071 |  
| param1 | Yes | The values you enter (You must enter at least one parameter). | string | abcdef |  
| param2 | No | The values you enter. | string | abcdef |  
| param3 | No | The values you enter. | string | abcdef |  
| param4 | No | The values you enter. | string | abcdef |  
| param5 | No | The values you enter. | string | abcdef |  
| param6 | No | The values you enter. | string | abcdef |  
| param7 | No | The values you enter. | string | abcdef |  
| param8 | No | The values you enter. | string | abcdef |  
| param9 | No | The values you enter. | string | abcdef |  
| param10 | No | The values you enter. | string | abcdef |  
  
  
## Example  
```php  
require __DIR__ . '/vendor/autoload.php';  

try{  
 $receptor = "09xxxxxxxxx";
 $type = 1;
 $template = "my-template";
 $param1 = '123456';
 $api = new \Ghasedak\GhasedakApi('api_key');
 $api->Verify($receptor, $type, $template, $param1);
}  
catch(\Ghasedak\Exceptions\ApiException $e){  
 echo $e->errorMessage();  
}  
catch(\Ghasedak\Exceptions\HttpException $e){  
 echo $e->errorMessage();  
}  
```  
:)  
  
## License  
Freely distributable under the terms of the [MIT](https://opensource.org/licenses/MIT) license.  
  
<h2 dir="rtl" id="table-of-contents-fa">فهرست مطالب </h2>

<ul dir="rtl">
	<li><a href="#install-fa">نصب</a></li>
	<li><a href="#usage-fa">استفاده</a></li>
	<ul>
		<li><a href="#parameters-fa">پارامترها</a></li>
		<li><a href="#example-fa">نمونه کد</a></li>
	</ul>
	<li><a href="#otp-fa">رمز عبور یک‌بار مصرف</a></li>
	<ul>
		<li><a href="#parameters1-fa">پارامترها</a></li>
		<li><a href="#example1-fa">نمونه کد</a></li>
	</ul>
	<li><a href="#licence-fa">مجوز</a></li>
</ul>
  
<h2 dir="rtl" id="install-fa">نصب</h2>
<p dir="rtl">ساده‌ترین راه برای نصب این پکیج استفاده از Composer است:</p>  
  
```sh  
composer require ghasedak/php  
```  
<p dir="rtl">
<a href="https://getcomposer.org/">Composer</a> سامانه‌ای برای مدیریت بسته‌های زبان PHP است که به شما امکان مدیریت (نصب / به روزرسانی) پکیج‌های نوشته شده در این زبان را می‌دهد. اگر با کامپوزر آشنایی ندارید، می‌توانید از طریق سایت <a href="https://getcomposer.org/">getcomposer.org</a> مستندات آن را مطالعه و اقدام به بارگیری و نصب آن کنید.
</p>
<p dir="rtl">
در صورت عدم تمایل به استفاده از کامپوزر، می‌توانید پکیج Ghasedak PHP را از <a href="https://github.com/ghasedakapi/ghasedak-php/archive/master.zip">اینجا</a> دانلود کرده و محتویات فایل زیپ را درون پروژه‌ی خود استفاده کنید. همچنین پوشه‌ای با نام <code>Example</code> درون پکیج وجود دارد که می‌توانید از آن برای یادگیری استفاده‌ی صحیح از پکیج استفاده کنید.
</p>
   
<h2 dir="rtl" id="usage-fa"> نحوه استفاده </h2>

<p dir="rtl">برای استفاده از این پکیج می‌بایست API key داشته باشید. جهت دریافت ابتدا در <a href="https://`/">سایت قاصدک</a> ثبت‌نام کنید و از پنل کاربری‌تان API key دریافت کنید.</p>  
<p dir="rtl">سپس باید فایل autoload را به پروژه‌ی خود اضافه کنید:</p>  
  
```php  
require __DIR__ . '/vendor/autoload.php';
```  
<p dir="rtl">یک instance از کلاس <code>Ghasedak</code> با API key خود بسازید:</p>
  
```php  
$api = new \Ghasedak\GhasedakApi( 'your_api_key');  
```  
<p dir="rtl">به خاطر داشته باشید که <code>your_api_key</code> را با کلید دریافتی از حساب قاصدک خود جایگزین کنید.</p>  
 
<p dir="rtl"> پیامک دلخواه‌تان را ارسال کنید:</p>  
  
```php  
$api->SendSimple(  
	"09xxxxxxxxx",  // receptor 
	"Hello World!", // message 
	"3000xxxxx" 	// choose a line number from your account
 );
```  
  
<h2 dir="rtl" id="parameters-fa">پارامترها</h2>

<div class="table-wrapper"><table dir="rtl">
<thead>
<tr>
<th>پارامتر</th>
<th>اجباری</th>
<th>توضیحات</th>
<th>نوع</th>
<th>مثال</th>
</tr>
</thead>
<tbody>
<tr>
<td>message</td>
<td>بله</td>
<td>متنی که باید ارسال شود.</td>
<td>string</td>
<td>سلام دنیا!</td>
</tr>
<tr>
<td>receptor</td>
<td>بله</td>
<td>شماره گیرنده پیام می باشد.</td>
<td>string</td>
<td>09111111111</td>
</tr>
<tr>
<td>linenumber</td>
<td>خیر</td>
<td>شماره فرستنده پیام می باشد، که اگر قید نشود از بین خطوط اختصاصی شما خط با اولویت بالاتر انتخاب می شود.<strong><code>( در صورت نداشتن خط اختصاصی باید linenumber را مشخص نمایید )</code></strong></td>
<td>string</td>
<td>5000222</td>
</tr>
<tr>
<td>senddate</td>
<td>خیر</td>
<td>تاریخ و زمان دقیق ارسال پیام بر اساس Unixtime می باشد که اگر قید نشود در همان لحظه پیام ارسال می شود.</td>
<td>string</td>
<td>1508144471</td>
</tr>
<tr>
<td>checkid</td>
<td>خیر</td>
<td>برای تعیین شماره ای یکتا از طرف کاربر برای هر پیامک به کار می رود و پس از ارسال پیامک می توان با متد <code>status</code> کلیه اطلاعات پیام ارسال شده را دریافت کرد.</td>
<td>string</td>
<td>2071</td>
</tr>
</tbody>
</table>
</div>
  
<h2 dir="rtl" id="example-fa">نمونه کد</h2>
<p dir="rtl"> کد زیر نمونه‌ای از متد ارسال تکی پیامک می‌باشد. لطفا توجه کنید که در صورت نداشتن خط اختصاصی می‌بایست حتما <code>linenumber</code> را وارد کنید. </p>
 
```php  
require __DIR__ . '/vendor/autoload.php';  
try{  
 $message = "Hello, World!";
 $lineNumber = null; // If you do not have a dedicated line, you must specify the line number  
 $receptor = "09xxxxxxxxx";
 $api = new \Ghasedak\GhasedakApi('api_key');
 $api->SendSimple($receptor,$message,$lineNumber);  
}  
catch(\Ghasedak\Exceptions\ApiException $e){  
 echo $e->errorMessage();  
}  
catch(\Ghasedak\Exceptions\HttpException $e){  
 echo $e->errorMessage();  
}  
```  
<h2 dir="rtl" id="otp-fa"> رمز عبور یکبار مصرف (OTP)  </h2>
<p dir="rtl"> رمز عبور یک‌بار مصرف برای اعتبارسنجی از طریق تلفن همراه و یا برای ورود دو مرحله‌ای (2FA) استفاده می‌شود.  </p>
<p dir="rtl">با استفاده از متد <code>Verify</code> می‌توانید تا سقف 10 <code>param</code> را ارسال کنید:  </p>

```php  
$api->setVerifyType(GhasedakApi::VERIFY_TEXT_TYPE)->Verify( 
 "09xxxxxxxxx", // receptor 
 "my-template", // name of the template which you've created in you account 
 "param1",      // parameters (supporting up to 10 parameters) 
 "param2", 
 "param3");
 ```  
 
 <h2 dir="rtl" id="parameters1-fa">پارامترها</h2>
 
<div class="table-wrapper" dir="rtl"><table>
<thead>
<tr>
<th>پارامتر</th>
<th>اجباری</th>
<th>توضیحات</th>
<th>نوع</th>
<th>مثال</th>
</tr>
</thead>
<tbody>
<tr>
<td>receptor</td>
<td>بله</td>
<td>شماره گیرنده پیام که با ( , ) از هم جدا می شوند.</td>
<td>string</td>
<td>09111111111</td>
</tr>
<tr>
<td>type</td>
<td>بله</td>
<td>برای ارسال پیام متنی عدد <code>1</code> و برای ارسال پیام صوتی عدد <code>2</code> را وارد کنید.</td>
<td>int</td>
<td>Hello, World!</td>
</tr>
<tr>
<td>template</td>
<td>بله</td>
<td>عنوان قالبی که در پنل خود ایجاد کرده اید.</td>
<td>string</td>
<td>my-template</td>
</tr>
<tr>
<td>checkid</td>
<td>خیر</td>
<td>برای تعیین شماره ای یکتا از طرف کاربر برای هر پیامک به کار می رود و پس از ارسال پیامک می توان با متد <code>status</code> کلیه اطلاعات پیام ارسال شده را دریافت کرد</td>
<td>string</td>
<td>2071</td>
</tr>
<tr>
<td>param1</td>
<td>بله</td>
<td>مقادیری که از سمت شما وارد می شود (وارد کردن حداقل 1 مورد اجباری است).</td>
<td>string</td>
<td>abcdef</td>
</tr>
<tr>
<td>param2</td>
<td>خیر</td>
<td>مقادیری که از سمت شما وارد می شود.</td>
<td>string</td>
<td>abcdef</td>
</tr>
<tr>
<td>param3</td>
<td>خیر</td>
<td>مقادیری که از سمت شما وارد می شود.</td>
<td>string</td>
<td>abcdef</td>
</tr>
<tr>
<td>param4</td>
<td>خیر</td>
<td>مقادیری که از سمت شما وارد می شود.</td>
<td>string</td>
<td>abcdef</td>
</tr>
<tr>
<td>param5</td>
<td>خیر</td>
<td>مقادیری که از سمت شما وارد می شود.</td>
<td>string</td>
<td>abcdef</td>
</tr>
<tr>
<td>param6</td>
<td>خیر</td>
<td>مقادیری که از سمت شما وارد می شود.</td>
<td>string</td>
<td>abcdef</td>
</tr>
<tr>
<td>param7</td>
<td>خیر</td>
<td>مقادیری که از سمت شما وارد می شود.</td>
<td>string</td>
<td>abcdef</td>
</tr>
<tr>
<td>param8</td>
<td>خیر</td>
<td>مقادیری که از سمت شما وارد می شود.</td>
<td>string</td>
<td>abcdef</td>
</tr>
<tr>
<td>param9</td>
<td>خیر</td>
<td>مقادیری که از سمت شما وارد می شود.</td>
<td>string</td>
<td>abcdef</td>
</tr>
<tr>
<td>param10</td>
<td>خیر</td>
<td>مقادیری که از سمت شما وارد می شود.</td>
<td>string</td>
<td>abcdef</td>
</tr>
</tbody>
</table>
</div>
  
  <h2 dir="rtl" id="example1-fa">نمونه کد</h2>
  
```php  
require __DIR__ . '/vendor/autoload.php';  
try{  
 $receptor = "09xxxxxxxxx";
 $type = 1;
 $template = "my-template";
 $param1 = '123456';
 $api = new \Ghasedak\GhasedakApi('api_key');
 $api->Verify($receptor, $type, $template, $param1);  
}  
catch(\Ghasedak\Exceptions\ApiException $e){  
 echo $e->errorMessage();  
}  
catch(\Ghasedak\Exceptions\HttpException $e){  
 echo $e->errorMessage();  
}  
```  

<h2 dir="rtl" id="licence-fa">مجوز</h2>
<p dir="rtl">این پکیج تحت مجوز <a href="https://opensource.org/licenses/MIT">MIT</a> منتشر شده است.  </p>