{if (!isset($session.user_id) || !$session.user_id) && (!isset($session.email) || !$session.email)}
    <form id="completeSignUp">
        <input type="hidden" name="item[vkontakte_id]" value="{if isset($hItem.vkontakte_id)}{$hItem.vkontakte_id}{else}0{/if}">
        <input type="hidden" name="item[twitter_id]" value="{if isset($hItem.twitter_id)}{$hItem.twitter_id}{else}0{/if}">
        <h4 class="b-section-h4">Enter your e-mail to complete registration</h4>
        <div class="in-text mB25px"><input type="text" name="item[email]" placeholder="your@email.address" /></div>
        <a class="button" onclick="SignUp.send();">Сохранить</a>
    </form>

    <script type="text/javascript">
        SignUp = {
            send: function(){
                $.ajax({
                    url: '/auth/complete_signup',
                    type: 'POST',
                    data: $('#completeSignUp').serialize(),
                    dataType: 'json',
                    success: function(data){
                        if (data.status == 'error'){
                            console.log('Error');
                        } else if (data.status == 1){
                            if (Auth.forceStop){
                                Auth.forceStop = null;
                                Auth.successful = 1;
                                return true;
                            }
                            else
                                window.location = window.location;
                        } else {
                            window.location = window.location;
                        }



                    }
                });
            }
        };

    </script>
{/if}