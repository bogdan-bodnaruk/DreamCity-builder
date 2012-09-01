<p class="code">&nbsp;Code: &#35;#ckeditor->[name=ckeditor2;id=ckeditor2;type=basic;validate=none;value=test text]#&#35;</p>
##ckeditor->[name=ckeditor2;id=ckeditor2;type=basic;validate=none;value=test text]##

<p class="code">&nbsp;Code: &#35;#ckeditor->[name=ckeditor1;id=ckeditor1;type=admin;validate=none;]#&#35;</p>
##ckeditor->[name=ckeditor1;id=ckeditor1;type=admin;validate=none;]##

<div style="padding: 10px;">
    <h2 style="color: #00008b;">Details:</h2>
    <table class="info_table">
        <tr>
            <td>required</td>
            <td> - This field can be empty. Values: [true, false]. Default: [true];</td>
        </tr>
        <tr>
            <td>name</td>
            <td> - Name of textfield. Default: [chars | mixed];</td>
        </tr>
        <tr>
            <td>value</td>
            <td> - Value: [num | chars | mixed];</td>
        </tr>
        <tr>
            <td>id, class</td>
            <td> - Value: [num | chars | mixed];</td>
        </tr>
        <tr>
            <td>style</td>
            <td> - Inline style. New line start after + (plus) ; Value: [css styles];</td>
        </tr>
        <tr>
            <td>validate</td>
            <td> - Validate type textfield. Values [none, text, num, phone, email, url, date, re_password, web, login];
                Default: [text];</td>
        </tr>
        <tr>
            <td>min</td>
            <td> - Minimum value of chars; Value: [num]. Default: [0]</td>
        </tr>
        <tr>
            <td>max</td>
            <td> - Maximum value of chars; Value: [num]. Default: [value in config file]; Default: [1000]</td>
        </tr>
        <tr>
            <td>type</td>
            <td> - Type of ckeditor. Values [basic, admin]</td>
        </tr>
    </table>
</div>