(function($){
    var globalajax;
    function doAjax(data, successcb){
        var options = {
            url: copa_ajax_url,
            method: 'POST',
            dataType: 'html',
            data: {
                action: 'copa_load_filter_vars',
                copa_filter_nonce: copa_filter_nonce
            }
        };
        options.data = $.extend(options.data, data);
        options.success = successcb;
        globalajax = $.ajax(options);
    }
    function stopAjax(){
        if(globalajax){
            globalajax.abort();
        }
    }
    function displayLoader($field){
        $field.closest('.copa_tournaments_filter').find('.filter-loading').removeClass('hidden');
    }
    function hideLoader($field){
        $field.closest('.copa_tournaments_filter').find('.filter-loading').addClass('hidden');
    }
    $(document).ready(function(){
        $('[name="dropdown_sp_tournament"]').on('change', function(e){
            var $this = $(this);
            var data = {
                sp_tournament: $this.children('option:selected').val()
            };
            displayLoader($this);
            doAjax(data, function(resp){
                var $field = $this.closest('.copa_tournaments_filter_inputs').find('[name="dropdown_sp_season"]');
                var $html = '';
                $field.children('option').remove();
                if(resp){
                    resp = JSON.parse(resp);
                    $.each(resp, function(k,v){
                        $html += '<option value="'+k+'">'+v+'</option>';
                    });
                    $field.append($html);
                }
                hideLoader($this);
                $field.trigger('change');
            });
        });
        $('[name="dropdown_sp_season"]').on('change', function(e){
            var $this = $(this);
            var data = {
                sp_tournament: $this.closest('.copa_tournaments_filter_inputs').find('[name="dropdown_sp_tournament"] option:selected').val(),
                sp_season: $this.children('option:selected').val()
            };
            displayLoader($this);
            doAjax(data, function(resp){
                var $html = '',
                $field = $this.closest('.copa_tournaments_filter_inputs').find('[name="dropdown_sp_table"]');
                $field.children('option').remove();
                if(resp){
                    resp = JSON.parse(resp);
                    $.each(resp, function(k,v){
                        $html += '<option value="'+v.ID+'">'+v.post_title+'</option>';
                    });
                    $field.append($html);
                }
                hideLoader($this);
                $field.trigger('change');
            });
        });
        $('[name="dropdown_sp_table"]').on('change', function(e){
            var $this = $(this);
            var data = {
                sp_table: $this.children('option:selected').val(),
                criteria: $this.closest('.copa_tournaments_filter').attr('data-layouttype')
            };
            displayLoader($this);
            doAjax(data, function(resp){
                var $html = '',
                $content = $this.closest('.copa_tournaments_filter_inputs').siblings('.copa_tournaments_filter_results');
                $content.html(resp);
                hideLoader($this);
            });
        });
        /* Tournaments results filter */
        $('[name="results_sp_tournament"]').on('change', function(e){
            var $this = $(this);
            var data = {
                sp_tournament: $this.children('option:selected').val()
            };
            displayLoader($this);
            doAjax(data, function(resp){
                var $field = $this.closest('.copa_tournaments_filter_inputs').find('[name="results_sp_season"]');
                var $html = '';
                $field.children('option').remove();
                if(resp){
                    resp = JSON.parse(resp);
                    $.each(resp, function(k,v){
                        $html += '<option value="'+k+'">'+v+'</option>';
                    });
                    $field.append($html);
                }
                hideLoader($this);
                $field.trigger('change');
            });
        });
        $('[name="results_sp_season"]').on('change', function(e){
            var $this = $(this);
            var data = {
                sp_tournament: $this.closest('.copa_tournaments_filter_inputs').find('[name="results_sp_tournament"] option:selected').val(),
                sp_season: $this.children('option:selected').val(),
                criteria: $this.closest('.copa_tournaments_filter').attr('data-layouttype'),
            };
            displayLoader($this);
            doAjax(data, function(resp){
                var $html = '',
                $content = $this.closest('.copa_tournaments_filter_inputs').siblings('.copa_tournaments_filter_results');
                $content.html(resp);
                hideLoader($this);
            });
        });
        /* Team players */
        $('[name="copa_sp_team"]').on('change', function(e){
            var $this = $(this);
            var data = {
                player_name: $this.closest('.copa_tournaments_filter_inputs').find('[name="copa_sp_player"]').val(),
                sp_team: $this.children('option:selected').val(),
                criteria: $this.closest('.copa_tournaments_filter').attr('data-layouttype'),
            };
            displayLoader($this);
            doAjax(data, function(resp){
                var $html = '',
                $content = $this.closest('.copa_tournaments_filter_inputs').siblings('.copa_tournaments_filter_results');
                $content.html(resp);
                hideLoader($this);
            });
        });
        $('[name="copa_sp_player"]').on('keyup', function(e){
            var $this = $(this);
            if(
                (e.keyCode < 48 && e.keyCode > 57)
                && (e.keyCode < 65 && e.keyCode > 90)
                && (e.keyCode < 96 && e.keyCode > 105)
                && e.keyCode != 32 && e.keyCode != 40 && e.keyCode != 8
            ){
                return false;
            }
            var data = {
                sp_team: $this.closest('.copa_tournaments_filter_inputs').find('[name="copa_sp_team"] option:selected').val(),
                player_name: $this.val(),
                criteria: $this.closest('.copa_tournaments_filter').attr('data-layouttype'),
            };
            stopAjax();
            displayLoader($this);
            doAjax(data, function(resp){
                var $html = '',
                $content = $this.closest('.copa_tournaments_filter_inputs').siblings('.copa_tournaments_filter_results');
                $content.html(resp);
                hideLoader($this);
            });
        });
    });

})(jQuery);