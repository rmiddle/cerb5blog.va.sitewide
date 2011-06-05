<?php
class PageSection_SetupVaSitewide extends Extension_PageSection {
	function render() {
		$tpl = DevblocksPlatform::getTemplateService();
		$visit = CerberusApplication::getVisit();
		
		$visit->set(ChConfigurationPage::ID, 'va_sitewide');
		
		$tpl->display('devblocks:cerb5blog.va.sitewide::configuration/va_sitewide.tpl');
	}
	
	function saveJsonAction() {
		try {
			$worker = CerberusApplication::getActiveWorker();
			
			if(!$worker || !$worker->is_superuser)
				throw new Exception("You are not a superuser.");
			
		    @$title = DevblocksPlatform::importGPC($_POST['title'],'string','');
		    @$logo = DevblocksPlatform::importGPC($_POST['logo'],'string');
	
		    if(empty($title))
		    	$title = 'Cerberus Helpdesk :: Team-based E-mail Management';
		    	
		    $settings = DevblocksPlatform::getPluginSettingsService();
		    $settings->set('cerberusweb.core',CerberusSettings::HELPDESK_TITLE, $title);
		    $settings->set('cerberusweb.core',CerberusSettings::HELPDESK_LOGO_URL, $logo); // [TODO] Enforce some kind of max resolution?
		    
			echo json_encode(array('status'=>true));
			return;
		    	
		} catch(Exception $e) {
			echo json_encode(array('status'=>false,'error'=>$e->getMessage()));
			return;
		}
	}
};