<volist name="permission_list" id="row" >
                                    <div class="">
                                        <div>
                                            <label class="checkbox" <notempty name="row['id']">title='{$row.id}'</notempty>>
                                           <input class="" type="checkbox" name="rules[]" value="<?php echo 1; ?>"/>{$row.title}
                                            </label>
                                        </div>
                                       <notempty name="row['children']">
                                           <span class="divsion">&nbsp;</span>
                                           <span class="">
                                               <volist name="row['children']" id="child">
                                                   <label class="checkbox" <notempty name="child['id']">title='{$child.id}'</notempty>>
                                                       <input class="auth_rules" type="checkbox" name="rules[]"
                                                       value="<?php echo $auth_rules[$child['url']] ?>"/>{$child.title}
                                                   </label>
                                               </volist>
                                           </span>
                                       </notempty>
				                    </div>
								</volist>