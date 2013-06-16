Auth = {
	vkontakte: function(reason) {
		if(typeof(reason) == 'undefined')
			reason = '';
		
		var url='https://oauth.vk.com/authorize?client_id='+vk_app_id+'&display=popup&scope=friends&redirect_uri='+encodeURIComponent('http://'+location.host+'/auth/step1/vkontakte/'+reason)+'&response_type=code';
		
		return Auth.popup(url, '/auth/step2/vkontakte/'+reason);
	},
	facebook: function(reason) {
		if(typeof(reason) == 'undefined')
			reason = '';
		
		var url='https://www.facebook.com/dialog/oauth?client_id='+fb_app_id+'&display=popup&scope=user_birthday,email,publish_actions&redirect_uri='+encodeURIComponent('http://'+location.host+'/auth/step1/facebook/'+reason);
		
		return Auth.popup(url, '/auth/step2/facebook/'+reason);
		
	},
	google: function(reason) {
		if(typeof(reason) == 'undefined')
			reason = '';
		
		var url='https://accounts.google.com/o/oauth2/auth?response_type=code&approval_prompt=auto&access_type=offline&client_id='+gl_app_id+'&display=popup&scope=https://www.googleapis.com/auth/userinfo.profile+https://www.googleapis.com/auth/userinfo.email&redirect_uri='+encodeURIComponent('http://'+location.host+'/auth/step1/google/'+reason);
		
		return Auth.popup(url, '/auth/step2/google/'+reason);
		
	},
    linkedin: function(reason) {
        if(typeof(reason) == 'undefined')
            reason = '';
        var url='https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id='+ln_app_id+'&scope=20r_emailaddress&state=HsIHpOmLWpQUP9th8K7cFwZDZD&redirect_uri='+encodeURIComponent('http://'+location.host+'/auth/step1/linkedin/'+reason);;

        return Auth.popup(url, '/auth/step2/linkedin/'+reason);
    },
    twitter: function(reason) {
        if(typeof(reason) == 'undefined')
            reason = '';
        var url=BASE_URL+'twitter/auth/'+reason;
        return Auth.popup(url, '/auth/twitter_step2/'+reason);
    },
	popup: function(url, step2) {
		Cookie.set('sl','0','0','/');
		
		Window.popup(url);
		Window.popupOpened = true;
		
		var popupCheck = function() {
		if (!Window.popupOpened) return false;
            try {
                if(Window.activePopup.closed/* || !Window.activePopup.top*/) {
                    Window.popupOpened = false;
                    console.log('Auth.popup setTimeout...OK');
                    Auth.authCallback(step2);
                    return true;
                }
            } catch(e) {
                Window.popupOpened = false;
                Auth.authCallback(step2);
                return true;
            }
            setTimeout(popupCheck, 100);
            console.log('Auth.popup setTimeout...');
		}
		setTimeout(popupCheck, 100);
		
		return false;
	},
	authCallback: function(url) {
		var state = Cookie.get('sl');
        console.log('Auth.authCallback '+url+' ...');
		if(state != null && parseInt(state) > 0) {
			$.ajax({
					url: url,
					dataType: 'json',
					beforeSend: function() {
						if(Window.params.dimmer && !Window.dimmerLoaded) {
							Window.placeDimmer();
						}
                        console.log('Auth.authCallback ajax ...');
						Window.placeLoadingIndicator();
					},
					success: function(data) {
                        console.log('Auth.authCallback ajax data.status='+data.status);
						Window.removeLoadingIndicator();
						if(data.status == 3)
							Window.create({'header':data.header, 'body': data.body}, 'win-social-signup-msg');
						else if(data.status == 2)
							Window.create({'header':data.header, 'body': data.body}, 'win-signup-social');
						else if(data.status == 1) {
                            if (Auth.forceStop){
                                Auth.forceStop = null;
                                Auth.successful = 1;
                                return true;
                            }
                            else
							    window.location = window.location;
						}
					}
				});
			}
	},
    forceStop: null,
    successful: null
}