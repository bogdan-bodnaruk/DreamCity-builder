<table class="data_table">
    <tr>
        <td style="width: 320px;">
            <form name="form1" method="POST" action="/ui/validate">
                Login:  ##text->[name=test1;validate=login;min=2;required=false;max=50;]##
            </form>
        </td>
        <td>
            <span class="code">Code: &#35;#text->[name=test1;validate=login;required=false;max=50;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>
            <form name="form2" method="POST" action="/ui/validate">
                Password:  ##password->[name=test2;min=5;max=50;]##
            </form>
        </td>
        <td>
            <span class="code">Code: &#35;#password->[name=test2;min=5;max=50;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>
            <form name="form3" method="POST" action="/ui/validate">
                Text:  ##text->[name=test3;min=3;max=50;]##
            </form>
        </td>
        <td>
            <span class="code">Code: &#35;#text->[name=test3;min=3;max=50;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>
            <form name="form4" method="POST" action="/ui/validate">
                Number:  ##text->[name=test4;min=2;max=5;size=6;validate=num]##
            </form>
        </td>
        <td>
            <span class="code">Code: &#35;#text->[name=test4;min=2;max=5;size=6;validate=num]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>
            <form name="form5" method="POST" action="/ui/validate">
                Phone:  ##text->[name=test5;validate=phone]##
            </form>
        </td>
        <td>
            <span class="code">Code: &#35;#text->[name=test5;validate=phone]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>
            <form name="form6" method="POST" action="/ui/validate">
                Email:  ##text->[name=test6;validate=email]##
            </form>
        </td>
        <td>
            <span class="code">Code: &#35;#text->[name=test6;validate=email]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>
            <form name="form7" method="POST" action="/ui/validate">
                URL:  ##text->[name=test7;validate=url]##
            </form>
        </td>
        <td>
            <span class="code">Code: &#35;#text->[name=test7;validate=url]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>
            <form name="form8" method="POST" action="/ui/validate">
                date (YYYY/mm/dd):  ##text->[name=test8;validate=dateYYYYmmdd]##
            </form>
        </td>
        <td>
            <span class="code">Code: &#35;#text->[name=test8;validate=dateYYYYmmdd]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>
            <form name="form9" method="POST" action="/ui/validate">
                date (mm/dd/YYYY):  ##text->[name=test9;validate=datemmddYYYY]##
            </form>
        </td>
        <td>
            <span class="code">Code: &#35;#text->[name=test9;validate=mmddYYYY]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>
            <form name="form10" method="POST" action="/ui/validate">
                None:  ##text->[name=test10;validate=none]##
            </form>
        </td>
        <td>
            <span class="code">Code: &#35;#text->[name=test10;validate=none]#&#35;</span>
        </td>
    </tr>
</table>
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
            <td>size</td>
            <td> - Size of chars of field. Value: [num]. Default: [15];</td>
        </tr>
        <tr>
            <td>max, min</td>
            <td>
                - Maxlength and Minlength. Value: [num]. Default: [0, 1000]
            </td>
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
            <td>js</td>
            <td>- Inline javascript code. First action e.q. (onClick) than : and code; new line start after + (plus)
                Values type by + (plus); Value: [js code];</td>
        </tr>
        <tr>
            <td>validate</td>
            <td> - Validate type. Values [none, text, num, phone, email, url, dateYYYYmmdd, datemmddYYYY, url, login];
                Default: [text];</td>
        </tr>
    </table>
</div>