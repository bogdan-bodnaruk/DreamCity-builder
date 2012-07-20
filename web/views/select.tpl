<table class="data_table">
    <tr>
        <td>##select->[name=select1;text={data::text_test1};value={data::text_test1}]##</td>
        <td>
            <span class="code">&#35;#select->[name=select1;text=&#123;data::text_test1&#125;;value=&#123;data::text_test1&#125;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##select->[name=select2;text=$[|i18n::text|,2,3,4,5,6];value=$[|config::app_path|,w,e,r,t,y]]##</td>
        <td>
            <span class="code">&#35;#select->[name=select2;text=$[|i18n::text|,2,3,4,5,6];value=$[|config::app_path|,w,e,r,t,y]]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##select->[name=select3;text=$[1];value=$[1];id=test_id;class=test_class;style=width:150px;]##</td>
        <td>
            <span class="code">&#35;#select->[name=select3;text=$[1];value=$[1];id=test_id;class=test_class;style=width:150px;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##select->[name=select4;selected=2;text=$[test1,test2];value=$[1,2];js=onChange:alert(123);]##</td>
        <td>
            <span class="code">&#35;#select->[name=select4;selected=2;text=$[test1,test2];value=$[1,2];js=onChange:alert(123);]#&#35;</span>
        </td>
    </tr>
</table>
<div style="padding: 10px;">
    <h2 style="color: #00008b;">Details:</h2>
    <table class="info_table">
        <tr>
            <td>name</td>
            <td> - Name of select. Default: [chars | mixed];</td>
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
            <td>selected</td>
            <td> - Some value from values; Value [char, num, mixed]</td>
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
    </table>
</div>