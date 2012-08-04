<table class="data_table">
    <tr>
        <td>##checkbox->[name=checkbox1;text=$[text 1,text 2,text 3];value=$[3,2,1]]##</td>
        <td>
            <span class="code">&#35;#checkbox->[name=checkbox1;text=$[text 1,text 2,text 3];value=$[3,2,1]]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##checkbox->[name=checkbox2;text={data::array};value={data::array};class=test_class;]##</td>
        <td>
            <span class="code">&#35;#checkbox->[name=checkbox2;text=&#123;data::array&#125;;value=&#123;data::array&#125;;class=test_class;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##checkbox->[name=checkbox3;checked=test;text={data::array};value={data::array};]##</td>
        <td>
            <span class="code">&#35;#checkbox->[name=checkbox3;checked=test;text=&#123;data::array&#125;;value=&#123;data::array&#125;;]#&#35;</span>
        </td>
    </tr>
</table>
<div style="padding: 10px;">
    <h2 style="color: #00008b;">Details:</h2>
    <table class="info_table">
        <tr>
            <td>name</td>
            <td> - Name of checkbox. Default: [chars | mixed];</td>
        </tr>
        <tr>
            <td>value</td>
            <td> - Value: [<a href="ui/array/">array</a>];</td>
        </tr>
        <tr>
            <td>text</td>
            <td> - Value: [<a href="ui/array/">array</a>];</td>
        </tr>
        <tr>
            <td>checked</td>
            <td> - Some value from values; Value [char, num, mixed]</td>
        </tr>
        <tr>
            <td>class</td>
            <td> - Value: [num | chars | mixed];</td>
        </tr>
    </table>
</div>