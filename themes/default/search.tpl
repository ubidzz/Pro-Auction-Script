<legend>{L_199}</legend>
<!-- IF ERROR ne '' -->
<div class="alert alert-info" align="center">
  <p class="errfont">{ERROR}</p>
</div>
<!-- ELSE -->
<!-- IF NUM_AUCTIONS gt 0 -->
<!-- INCLUDE browse.tpl -->
<!-- ELSE -->
<div class="alert alert-info" align="center"> {L_198} </div>
<!-- ENDIF -->
<!-- ENDIF -->
