<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<fieldset>
    <legend>单元测试窗口</legend>
    @if ($errors->all())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{route("unit.request")}}" method="post">
        @csrf
        <table>
            <tr>
                <td>命名空间(命名空间可以包含类名，然后下面的类名可以省略)</td>
                <td><input type="text" name="namespace" value="{{old('namespace')??""}}"></td>
            </tr>
            <tr>
                <td>类名</td>
                <td><input type="text" name="className" value="{{old('className')??""}}"></td>
            </tr>
            <tr>
                <td>测试方法名</td>
                <td><input type="text" name="action" value="{{old('action')??""}}"></td>
            </tr>
            <tr>
                <td>传递参数以英文 | 分割</td>
                <td><input type="text" name="param" value="{{old('param')??""}}"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="开始测试"></td>
            </tr>
        </table>
    </form>
</fieldset>
</body>
</html>

<style>
    input {
        width: 100%;
    }
    input[type=submit] {
        margin-top: 50px;
        box-sizing: content-box;
        -moz-box-sizing: content-box;
        -webkit-box-sizing: content-box;
        background-color: #9bd1de;
        border-radius: 5px;
    }
    table>tbody>tr>td:nth-of-type(2) {
        width:50%;
    }
</style>