<?php

class WFU_Personal_Data_Policy {
	private $name;
	private $description;
	
	private $consent_policy;
	private $permissions_policy;
	private $log_policy;
	private $parameters;
	
	private $roles_included;
	private $roles_excluded;
	private $users_included;
	private $users_excluded;
	
	function __construct() {
		$this->name = "Personal Data Policy";
		$this->_initialize_consent_policy();
		$this->_initialize_permissions_policy();
		$this->_initialize_log_policy();
		$this->_initialize_parameters();
		$this->roles_included = array( "all" );
		$this->roles_excluded = array();
		$this->users_included = array();
		$this->users_excluded = array();
	}
	
	private function _initialize_consent_policy() {
		$operationdefs = wfu_personal_data_operations();
		$operations_indexed = array();
		$operations_slug_index = array();
		$operations_children_index = array();
		//extract only atomic operations
		foreach ( $operationdefs as $def ) {
			$opID = $def["ID"];
			$operations_indexed[$opID] = $def;
			$operations_indexed[$opID]["ref_count"] = 0;
			$operations_indexed[$opID]["children"] = array();
		}
		//set ref_count property to count how many times operation appears as
		//parent
		foreach ( $operations_indexed as $ind => $def )
			if ( $def["Parent"] > 0 ) {
				$operations_indexed[$def["Parent"]]["ref_count"] ++;
				$ind2 = $def["Parent"];
				while ( $ind2 > 0 ) {
					array_push($operations_indexed[$ind2]["children"], $ind);
					$ind2 = $operations_indexed[$ind2]["Parent"];
				}
			}
		foreach ( $operations_indexed as $ind => $def ) {
			$operations_children_index[$ind] = $def["children"];
			//remove ref_count property, we do not need it anymore
			unset($operations_indexed[$ind]["ref_count"]);
			//set all operations allowed property by default allowed state
			$operations_indexed[$ind]["Allowed"] = ( $operations_indexed[$ind]["DefAllowed"] == 1 );
			//set all operations needsconsent property by default consent state
			$operations_indexed[$ind]["NeedsConsent"] = ( $operations_indexed[$ind]["DefAllowed"] == 1 && $operations_indexed[$ind]["DefConsent"] == 1 );
			//create index of slugs pointing to the operations
			$slug = $operations_indexed[$ind]["Slug"];
			if ( !isset($operations_slug_index[$slug]) ) $operations_slug_index[$slug] = array();
			array_push($operations_slug_index[$slug], $ind);
		}
		//initialize consent questions; by default only one question is defined
		//for all operations requiring consent
		$defitem = array(
			"index"			=> 1,
			"label"			=> "I agree to allow the plugin to use my personal data",
			"location"		=> "right",
			"preselect"		=> 0,
			"operations"	=> array()
		);
		foreach ( $operations_indexed as $def ) 
			if ( $def["NeedsConsent"] ) $defitem["operations"][$def["ID"]] = 1;
		$defquestion = array(
			"title"		=> "",
			"location"	=> "top",
			"x"			=> 1,
			"y"			=> 1,
			"grouped"	=> 0,
			"type"		=> "checkbox",
			"items"		=> array( $defitem )
		);
		$defquestions = array( $defquestion );
		$this->consent_policy = array(
			"structure"			=> wfu_get_pd_operations_structure(true),
			"children_index"	=> $operations_children_index,
			"operations"		=> $operations_indexed,
			"slugs_index"		=> $operations_slug_index,
			"questions"			=> $defquestions
		);
	}
	
	private function _initialize_permissions_policy() {
		$permissiondefs = wfu_personal_data_permissions();
		$permissions_indexed = array();
		$permissions_slug_index = array();
		$permissions_children_index = array();
		//extract only atomic permissions
		foreach ( $permissiondefs as $def ) {
			$perID = $def["ID"];
			$permissions_indexed[$perID] = $def;
			$permissions_indexed[$perID]["children"] = array();
		}
		//fill children property
		foreach ( $permissions_indexed as $ind => $def )
			if ( $def["Parent"] > 0 ) {
				$ind2 = $def["Parent"];
				while ( $ind2 > 0 ) {
					array_push($permissions_indexed[$ind2]["children"], $ind);
					$ind2 = $permissions_indexed[$ind2]["Parent"];
				}
			}
		foreach ( $permissions_indexed as $ind => $def ) {
			$permissions_children_index[$ind] = $def["children"];
			//set allowed locations of permissions to default values
			$permissions_indexed[$ind]["Allowed"] = $permissions_indexed[$ind]["Default"];
			//create index of slugs pointing to the permissions
			$slug = $permissions_indexed[$ind]["Slug"];
			if ( !isset($permissions_slug_index[$slug]) ) $permissions_slug_index[$slug] = array();
			array_push($permissions_slug_index[$slug], $ind);
		}
		$this->permissions_policy = array(
			"structure"			=> wfu_get_permissions_structure(true),
			"children_index"	=> $permissions_children_index,
			"permissions"		=> $permissions_indexed,
			"slugs_index"		=> $permissions_slug_index
		);
	}

	private function _initialize_log_policy() {
		$logactiondefs = wfu_personal_data_logactions();
		$logactions_indexed = array();
		$logactions_slug_index = array();
		$logactions_children_index = array();
		//extract only atomic log actions
		foreach ( $logactiondefs as $def ) {
			$actID = $def["ID"];
			$logactions_indexed[$actID] = $def;
			$logactions_indexed[$actID]["ref_count"] = 0;
			$logactions_indexed[$actID]["children"] = array();
		}
		//fill children property
		foreach ( $logactions_indexed as $ind => $def )
			if ( $def["Parent"] > 0 ) {
				$ind2 = $def["Parent"];
				while ( $ind2 > 0 ) {
					array_push($logactions_indexed[$ind2]["children"], $ind);
					$ind2 = $logactions_indexed[$ind2]["Parent"];
				}
			}
		foreach ( $logactions_indexed as $ind => $def ) {
			$logactions_children_index[$ind] = $def["children"];
			//set allowed entities of log actions to default values
			$logactions_indexed[$ind]["Allowed"] = $logactions_indexed[$ind]["Default"];
			//create index of slugs pointing to the permissions
			$slug = $logactions_indexed[$ind]["Slug"];
			if ( !isset($logactions_slug_index[$slug]) ) $logactions_slug_index[$slug] = array();
			array_push($logactions_slug_index[$slug], $ind);
		}
		$this->log_policy = array(
			"structure"			=> wfu_get_logactions_structure(true),
			"children_index"	=> $logactions_children_index,
			"logactions"		=> $logactions_indexed,
			"slugs_index"		=> $logactions_slug_index
		);
	}
	
	private function _initialize_parameters() {
		$this->parameters = array(
			"disclaimer_link"	=> ""
		);
	}

	public function get_name() {
		return $this->name;
	}

	public function set_name($name) {
		$this->name = $name;
	}

	public function get_consent_policy($compact = false) {
		$conpol = $this->consent_policy;
		//if a compact structure is required then remove unnecessary items from
		//operations array
		if ( $compact ) {
			foreach ( $conpol["operations"] as &$op ) {
				unset($op["Description"]);
			}
		}
		return $conpol;
	}

	public function get_permissions_policy($compact = false) {
		$perpol = $this->permissions_policy;
		//if a compact structure is required then remove unnecessary items from
		//permissions array
		if ( $compact ) {
			foreach ( $perpol["permissions"] as &$per ) {
				unset($per["Description"]);
			}
		}
		return $perpol;
	}

	public function get_logactions_policy($compact = false) {
		$logpol = $this->log_policy;
		//if a compact structure is required then remove unnecessary items from
		//log actions array
		if ( $compact ) {
			foreach ( $logpol["logactions"] as &$act ) {
				unset($act["Description"]);
			}
		}
		return $logpol;
	}

	public function get_parameters() {
		return $this->parameters;
	}

	public function get_assigned_users() {
		$users = array();
		$users["roles_included"] = $this->roles_included;
		$users["roles_excluded"] = $this->roles_excluded;
		$users["users_included"] = $this->users_included;
		$users["users_excluded"] = $this->users_excluded;
		return $users;
	}

	public function export_policy() {
		$export_data = array();
		//process basic info
		$export_data["name"] = $this->name;
		$export_data["description"] = $this->description;
		//process consent policy
		$export_data["operations_allowed"] = array();
		$export_data["operations_needing_consent"] = array();
		foreach ($this->consent_policy["operations"] as $id => $operation ) {
			$allowed = ( count($operation["children"]) == 0 && $operation["Allowed"] );
			$needs_consent = ( $allowed && $operation["NeedsConsent"] );
			if ( $allowed ) array_push($export_data["operations_allowed"], $id);
			if ( $needs_consent ) array_push($export_data["operations_needing_consent"], $id);
		}
		$export_data["consent_questions"] = $this->consent_policy["questions"];
		//process permissions policy
		$export_data["permissions_allowed"] = array();
		foreach ($this->permissions_policy["permissions"] as $id => $permission ) {
			$allowed = ( count($permission["children"]) == 0 && $permission["Allowed"] );			$needs_consent = ( $allowed && $operation["NeedsConsent"] );
			if ( $allowed ) array_push($export_data["permissions_allowed"], $id);
		}
		//process log actions policy
		$export_data["logactions_allowed"] = array();
		foreach ($this->log_policy["logactions"] as $id => $logaction ) {
			$allowed = ( count($logaction["children"]) == 0 && $logaction["Allowed"] );			$needs_consent = ( $allowed && $operation["NeedsConsent"] );
			if ( $allowed ) array_push($export_data["logactions_allowed"], $id);
		}
		//process users
		$export_data["roles_included"] = $this->roles_included;
		$export_data["roles_excluded"] = $this->roles_excluded;
		$export_data["users_included"] = $this->users_included;
		$export_data["users_excluded"] = $this->users_excluded;
		//process parameters
		$export_data["parameters"] = $this->parameters;
		
		return $export_data;
	}	
	
}

?>