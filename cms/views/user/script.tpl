<script  type="text/javascript">
    $(document).ready(function(){
        var toggle = function() {
            $('select[name=status]').val() == 'Decan' ? $('tr.univer').show(0) : $('tr.univer').hide(0);
        }

        toggle();
        $('select[name=status]').live('change', function(){
            toggle();
        });
    });
</script>