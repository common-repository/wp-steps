jQuery(document).ready(function() {
	"use strict";
	jQuery('.gonextstep').on('click',function(){ 
												var shownext = jQuery(this).data('step2go'); 
												var dontshow = jQuery(this).data('step2hide'); 
												jQuery('.wpsteps_step_'+dontshow).hide();
												jQuery('.wpsteps_step_'+shownext).show();
										});
	jQuery('.gobackstep').on('click',function(){ 
												var shownext = jQuery(this).data('step2go'); 
												var dontshow = jQuery(this).data('step2hide'); 
												jQuery('.wpsteps_step_'+dontshow).hide();
												jQuery('.wpsteps_step_'+shownext).show();
										});
});