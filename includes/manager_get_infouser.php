<?php
/**
* @ Project: ID Account System 1.5.0
* @ Author: Yplitgroup (c)2012
* @ Email: yplitgroup@gmail.com
* @ Website: http://lemon9x.com 
* @ Phone: 0166.26.26.009
* @ Project ID: 876609683c4c7e392848e94d9f62e149
**/
 
// ############### CHECK ##############
if( !defined( 'IS_MAIN' ) ) die(" Stop!!! ");
if( !defined( 'IS_USER' ) ) yplitgroupRedirectLogin( $_SERVER['REQUEST_URI'] );

// ################ USER FIELS DATA #######################
$db->query( 'SELECT * FROM `'. TABLE_PREFIX .'userfield` WHERE `userid` = '. USERID );
if( $db->nums() > 0 )
	$fiels_data = $db->sql_fetch_assoc();

// ############### GET CUSTOM  FIELDS #####################
$customfields_other = $customfields_profile = $customfields_option = '';
$res = $db->query( "SELECT * FROM " . TABLE_PREFIX . "profilefieldcategory ORDER BY displayorder"); 

	// cache profile field categories
	$pfcs = array(0);
	$pfcs_result = $db->query("
		SELECT * FROM " . TABLE_PREFIX . "profilefieldcategory
		ORDER BY displayorder
	");
	while ($pfc = $db->sql_fetchrow($pfcs_result))
	{
		$pfcs["$pfc[profilefieldcategoryid]"] = $pfc['profilefieldcategoryid'];
	}
	$db->freeresult($pfcs_result);

	// query profile fields
	$profilefields = $db->query("
		SELECT profilefieldid, profilefieldcategoryid, type, form, displayorder,
			IF(required=2, 0, required) AS required,
			editable, hidden, searchable, memberlist, data
		FROM " . TABLE_PREFIX . "profilefield
	");

	if( $db->nums( $profilefields ) > 0 )
	{
		$forms = array(
			0 => yplitgroupGetPhrase('edit_your_details','global'),
			1 => yplitgroupGetPhrase('options','global') .': '. yplitgroupGetPhrase('log_in','global') .' / '. yplitgroupGetPhrase('privacy','global'),
			2 => yplitgroupGetPhrase('options','global') .': '. yplitgroupGetPhrase('messaging','global') .' / '. yplitgroupGetPhrase('notification','global'),
			3 => yplitgroupGetPhrase('options','global') .': '. yplitgroupGetPhrase('thread_viewing','global'),
			4 => yplitgroupGetPhrase('options','global') .': '. yplitgroupGetPhrase('date') .' / '. yplitgroupGetPhrase('time','global'),
			5 =>  yplitgroupGetPhrase('options','global') .': '. yplitgroupGetPhrase('other','global'),
		);
		$optionfields = array(
			'required'   => yplitgroupGetPhrase('required','global'),
			'editable'   => yplitgroupGetPhrase('editable','global'),
			'hidden'     => yplitgroupGetPhrase('hidden','global'),
			'searchable' => yplitgroupGetPhrase('searchable','global'),
			'memberlist' => yplitgroupGetPhrase('members_list','global'),
		);

		$fields = array();

		while ($profilefield = $db->sql_fetchrow($profilefields))
		{
			$profilefield['title'] = htmlspecialchars_uni( yplitgroupGetPhrase( 'field' . $profilefield['profilefieldid'] . '_title', 'cprofilefield' ) );
			$fields["{$profilefield['form']}"]["$profilefield[profilefieldcategoryid]"]["{$profilefield['displayorder']}"]["{$profilefield['profilefieldid']}"] = $profilefield;
		}
		// sort by form and displayorder
		foreach ($fields AS $profilefieldcategoryid => $profilefieldcategory)
		{
			ksort($fields["$profilefieldcategoryid"]);
			foreach (array_keys($fields["$profilefieldcategoryid"]) AS $key)
			{
				ksort($fields["$profilefieldcategoryid"]["$key"]);
			}
		}

		$numareas = sizeof($fields);
		$areacount = 0;

		$list_require = array();
		foreach ($forms AS $formid => $formname)
		{
			if (is_array($fields["$formid"]))
			{
				foreach ($pfcs AS $pfcid)
				{
					if (is_array($fields["$formid"]["$pfcid"]))
					{
						foreach ($fields["$formid"]["$pfcid"] AS $displayorder => $profilefields)
						{
							
							foreach ($profilefields AS $_profilefieldid => $profilefield)
							{
								$fiels_options = array();
								foreach ($optionfields AS $fieldname => $optionname)
								{
									if ($profilefield["$fieldname"])
									{
										$fiels_options[] = $optionname;
									}
								}
								if( $profilefield['required'] == 1 || $profilefield['required'] == 3 )
								{
									$list_require[] = $profilefield['profilefieldid'];
								}
								$profilefieldname = "field$profilefield[profilefieldid]";
								$optionalname = $profilefieldname . '_opt';
								$optionalfield = '';
								$optional = '';
								$profilefield['currentvalue'] = '';
								if( !empty( $error ) )
								{
									$profilefield['currentvalue'] = $_REQUEST['userfield']["$profilefieldname"];
								}
								if ($profilefield['type'] == 'input' OR $profilefield['type'] == 'textarea')
								{
								
								}
								$custom_field_holder = '';
								if ($profilefield['type'] == 'input')
								{
									if (empty($profilefield['currentvalue']) AND !empty($profilefield['data']))
									{
										$profilefield['currentvalue'] = $profilefield['data'];
									}
									else
									{
										$profilefield['currentvalue'] = htmlspecialchars_uni( $profilefield['currentvalue'] );
									}
									$custom_field_holder = '<input type="text" class="primary textbox" name="userfield['. $profilefieldname .']" id="cfield_'. $profilefield['profilefieldid'] .'" value="'. ( !empty( $fiels_data['field'.$profilefield['profilefieldid']] ) ? $fiels_data['field'.$profilefield['profilefieldid']] : '' ) .'" maxlength="' . $profilefield['maxlength'] . '" tabindex="1" /><p class="description">' . $profilefield['description'] . '</p><input type="hidden" name="userfield[' . $profilefieldname . '_set]" value="1" />';
								}
								elseif ($profilefield['type'] == 'textarea')
								{
									if ( empty( $profilefield['currentvalue'] ) AND !empty( $profilefield['data'] ) )
									{
										$profilefield['currentvalue'] = $profilefield['data'];
									}
									else
									{
										$profilefield['currentvalue'] = htmlspecialchars_uni( $profilefield['currentvalue'] );
									}
									$custom_field_holder = '<div><textarea class="primary textbox" name="userfield[' . $profilefieldname . ']" id="cfield_' . $profilefield['profilefieldid'] . '" rows="' . $profilefield['height'] . '" cols="60" tabindex="1">' . ( !empty( $fiels_data['field'.$profilefield['profilefieldid']] ) ? $fiels_data['field'.$profilefield['profilefieldid']] : '' ) . '</textarea></div><p class="description">'. $profilefield['description'] . '</p><input type="hidden" name="userfield['. $profilefieldname . '_set]" value="1" />';
								}
								else if ($profilefield['type'] == 'select')
								{
									$data = unserialize($profilefield['data']);
									$selectbits = '';
									foreach ( $data AS $key => $val )
									{
										$key++;
										$selected = '';
										if (isset($profilefield['currentvalue']))
										{
											if (trim($val) == $fiels_data['field'.$profilefield['profilefieldid']])
											{
												$selected = 'selected="selected"';
												$foundselect = 1;
											}
										}
										else if ($profilefield['def'] AND $key == 1)
										{
											$selected = 'selected="selected"';
											$foundselect = 1;
										}
										$selectbits .= '<option value="'. $key . '" ' . $selected . '>' . $val . '</option>';
									}
									if ($profilefield['optional'])
									{
										if (!$foundselect AND $profilefield['currentvalue'])
										{
											$optional = htmlspecialchars_uni($profilefield['currentvalue']);
										}
										$optionalfield = '<label for="userfield_'. $optionalname .'">' . yplitgroupGetPhrase( 'or_enter_your_choice_here', 'user' ) . ':</label><div><input type="text" class="primary textbox" id="userfield_' . $optionalname . '" name="userfield[' . $optionalname .']" value="' . $optional .'" tabindex="1" maxlength="' . $profilefield['maxlength'] . '" ' . $tabindex . ' /></div>';
									}
									if (!$foundselect)
									{
										$selected = 'selected="selected"';
									}
									else
									{
										$selected = '';
									}
									$show['noemptyoption'] = iif($profilefield['def'] != 2, true, false);
									$custom_field_holder = '<select class="primary" name="userfield['. $profilefieldname .']" id="cfield_'. $profilefield['profilefieldid'] .'" tabindex="1">';
									if( $show['noemptyoption'] )
									{
										$custom_field_holder .= '<option value="0" '. $selected .'></option>';
									}
									$custom_field_holder .= $selectbits .'</select><input type="hidden" name="userfield['. $profilefieldname .'_set]" value="1" />'. $optionalfield .'<p class="description">'. $profilefield['description'] . '</p>';
								}
								else if ($profilefield['type'] == 'radio')
								{
									$data['data'] = unserialize($profilefield['data']);
									$radiobits = '';
									$foundfield = 0;
									foreach ($data['data'] AS $key => $val)
									{
										$key++;
										$checked = '';
										if (!$profilefield['currentvalue'] AND $key == 1 AND $profilefield['def'] == 1)
										{
											$checked = 'checked="checked"';
										}
										else if (trim($val) == $fiels_data['field'.$profilefield['profilefieldid']] )
										{
											$checked = 'checked="checked"';
											$foundfield = 1;
										}
										$radiobits .= '<li><label for="rb_cpf_'. $profilefieldname .'_'. $key .'"><input type="radio" name="userfield['. $profilefieldname .']" value="'. $key .'" id="rb_cpf_'. $profilefieldname .'_'. $key. '" tabindex="1" '. $checked .' /> '. $val .'</label></li>';
									}
									if ($profilefield['optional'])
									{
										if (!$foundfield AND $fiels_data['field'.$profilefield['profilefieldid']])
										{
											$optional = htmlspecialchars_uni($profilefield['currentvalue']);
										}
										$optionalfield = '<label for="userfield_'. $optionalname .'">'. yplitgroupGetPhrase('or_enter_your_choice_here', 'user') .':</label><div><input type="text" class="primary textbox" id="userfield_'. $optionalname .'" name="userfield['. $optionalname .']" value="'. $optional .'" tabindex="1" maxlength="'. $profilefield['maxlength'] .'" '. $tabindex .' /></div>';
									}
									$custom_field_holder = '<ul class="checkradio group">'. $radiobits .'</ul><input type="hidden" name="userfield['. $profilefieldname .'_set]" value="1" />'. $optionalfield .'<p class="description">'. $profilefield['description'] .'</p>';
								}
								else if ($profilefield['type'] == 'checkbox')
								{
									$data = unserialize($profilefield['data']);
									$radiobits = '';
									foreach ($data AS $key => $val)
									{
										if ( $fiels_data['field'.$profilefield['profilefieldid']] & pow(2,$key))
										{
											$checked = 'checked="checked"';
										}
										else
										{
											$checked = '';
										}
										$key++;
										$radiobits .= '<li><label for="cb_cpf_'. $profilefieldname .'_'. $key .'"><input type="checkbox" name="userfield['. $profilefieldname .'][]" value="'. $key .'" id="cb_cpf_'. $profilefieldname .'_'. $key .'" tabindex="1" '. $checked .' /> '. $val .'</label></li>';
									}
									$custom_field_holder = '<ul class="checkradio group">'. $radiobits. '</ul><input type="hidden" name="userfield['. $profilefieldname. '_set]" value="1" />'. $optionalfield. '<p class="description">'. $profilefield['description'] .'</p>';
								}
								else if ($profilefield['type'] == 'select_multiple')
								{
									$data = unserialize($profilefield['data']);
									$selectbits = '';
									$selected = '';
									if ($profilefield['height'] == 0)
									{
										$profilefield['height'] = count($data);
									}
									foreach ($data AS $key => $val)
									{
										if ( $fiels_data['field'.$profilefield['profilefieldid']] & pow(2, $key))
										{
											$selected = 'selected="selected"';
										}
										else
										{
											$selected = '';
										}
										$key++;
										$selectbits .= '<option value="'. $key .'" '. $selected .'>'. $val .'</option>';
									}
									$custom_field_holder = '<select class="primary" name="userfield['. $profilefieldname .'][]" id="cfield_'. $profilefield['profilefieldid'] .'" tabindex="1" size="'. $profilefield['height'] .'" multiple="multiple">'. $selectbits .'</select><p class="description">'. $profilefield['description'] .'</p><input type="hidden" name="userfield['. $profilefieldname .'_set]" value="1" />';
								}
								if ($profilefield['required'] == 2)
								{
									$profile_variable =& $customfields_other;
									$require = '';
								}
								else // required to be filled in
								{
									if ($profilefield['form'])
									{
										$profile_variable =& $customfields_option;
									}
									else
									{
										$profile_variable =& $customfields_profile;
									}
									$js_require[] = 'cfield_'. $profilefield['profilefieldid'];
								}
								$profile_variable .= '<div class="fiel"><label>'. $profilefield['title'] . ( in_array( $profilefield['profilefieldid'], $list_require ) ? ' (*)' : '' ) .'</label><div class="rightcol">'. $custom_field_holder .'</div></div>';
							}
						}
					}
				}
			}
		}
	}
	
?>