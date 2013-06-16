<h3 class="b-section-h3">Sign-in with</h3>
<a class="b-idea-share-btn fb mR10px" onclick="Auth.facebook({if isset($reason) && $reason}'{$reason}'{/if});"></a>
<a class="b-idea-share-btn vk mR10px" onclick="Auth.vkontakte({if isset($reason) && $reason}'{$reason}'{/if});"></a>
<a class="b-idea-share-btn gp mR10px" onclick="Auth.google({if isset($reason) && $reason}'{$reason}'{/if});"></a>
<a class="b-idea-share-btn tw" onclick="Auth.twitter({if isset($reason) && $reason}'{$reason}'{/if});"></a>