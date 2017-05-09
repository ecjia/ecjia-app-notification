<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.notice_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="row-fluid">
	<div class="span3">
		<div class="setting-group">
	        <span class="setting-group-title"><i class="fontello-icon-cog"></i>{lang key='notification::notification.notification_channel_group'}</span>
	        <ul class="nav nav-list m_t10">
				<li><a class="setting-group-item data-pjax {if $smarty.get.type eq sms || !$smarty.get.type}llv-active{/if}" href='{url path="notification/admin_notification_channel/init" args="type=sms"}'>{lang key='notification::notification.sms'}</a></li>
				<li><a class="setting-group-item data-pjax {if $smarty.get.type eq mail}llv-active{/if}" href='{url path="notification/admin_notification_channel/init" args="type=mail"}'>{lang key='notification::notification.mail'}</a></li>
	        </ul>
	        <br>
		</div>
	</div>
	<div class="span9">
		<h3 class="heading">{if $ur_here}{$ur_here}{/if}</h3>
		
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w100">{lang key='notification::notification.name'}</th>
					<th>{lang key='notification::notification.desc'}</th>
					<th class="w80">{lang key='notification::notification.sort_order'}</th>
					<th class="w80">{lang key='notification::notification.is_enabled'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$list.item item=val} -->
				<tr>
					<td >
						<!-- {if $val.enabled == 1} -->
							<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('notification/admin_notification_channel/edit_name')}&type={$val.channel_type}" data-name="channel_name" data-pk="{$val.channel_id}"  data-title="{lang key='notification::notification.edit_channel_name'}">{$val.channel_name}</span>
						<!-- {else} -->
							{$val.channel_name}
						<!-- {/if} -->
					</td>
					<td class="hide-edit-area">
						<!-- {if $val.enabled == 1} -->
							{$val.channel_desc|nl2br}
							<div class="edit-list">
								<a class="data-pjax" href='{RC_Uri::url("notification/admin_notification_channel/edit", "code={$val.channel_code}")}&type={$val.channel_type}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
								<a class="switch ecjiafc-red" href="javascript:;" data-url='{RC_Uri::url("notification/admin_notification_channel/switch_state", "code={$val.channel_code}")}&enabled=0' title="{lang key='notification::notification.disable'}">{lang key='notification::notification.disable'}</a>
							</div>
						<!-- {else} -->
							{$val.channel_desc|nl2br}
							<div class="edit-list">
								<a class="switch" href="javascript:;" data-url='{RC_Uri::url("notification/admin_notification_channel/switch_state", "code={$val.channel_code}")}&enabled=1' title="{lang key='notification::notification.enable'}">{lang key='notification::notification.enable'}</a>
							</div>
						<!-- {/if} -->
					</td>
					<td>
						<!-- {if $val.enabled == 1} -->
							<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('notification/admin_notification_channel/edit_order')}&type={$val.channel_type}" data-name="sort_order" data-pk="{$val.channel_id}" data-title="{lang key='notification::notification.edit_channel_sort'}">{$val.sort_order}</span>
						<!-- {else} -->
							{$val.sort_order}
						<!-- {/if} -->
					</td>
					<td>
						<i class="{if $val.enabled eq 1}fontello-icon-ok{else}fontello-icon-cancel{/if}"></i>
					</td>
				</tr>
				<!-- {foreachelse} -->
				<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$list.page} -->
	</div>
</div>    
<!-- {/block} -->