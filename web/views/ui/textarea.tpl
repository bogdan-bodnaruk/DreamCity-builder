<table class="data_table">
    <tr>
        <td>##textarea->[name=textarea1]##</td>
        <td>
            <span class="code">Code: &#35;#textarea->[name=textarea1]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##textarea->[name=textarea2;rows=5;cols=20;placeholder=Test placeholder]##</td>
        <td>
            <span class="code">Code: &#35;#textarea->[name=textarea2;rows=5;cols=20;placeholder=Test placeholder]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##textarea->[name=textarea3;rows=5;cols=20;value=Test value;style=resize:none;id=test_id;class=test_class]##</td>
        <td>
            <span class="code">Code: &#35;#textarea->[name=textarea3;rows=5;cols=20;value=Test value;style=resize:none;id=test_id;class=test_class]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##textarea->[name=textarea4;min=1;max=100;js=onClick:alert(true);]##</td>
        <td>
            <span class="code">Code: &#35;#textarea->[name=textarea4;min=1;max=100;js=onClick:alert(true);]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##textarea->[name=textarea5;rows=5;cols=20;required=false]##</td>
        <td>
            <span class="code">Code: &#35;#textarea->[name=textarea5;rows=5;cols=20;required=false]#&#35;</span>
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
            <td>cols</td>
            <td> - cols for textarea; Values: [num]; Default: [25]</td>
        </tr>
        <tr>
            <td>rows</td>
            <td> - rows  for textarea; Values: [num]; Default: [5]</td>
        </tr>
    </table>
</div>