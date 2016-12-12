<?php
/**
 * Main admin UI Template
 */
?>
<div class="notifier-status{{#if general/enable}}-active{{else}}-inactive{{/if}}">
	<label><?php echo esc_html__( 'Hook', 'facetwp-manipulator' ); ?></label>
	<div class="def-row" title="{{general/event}}">
		{{general/event}}&nbsp;
	</div>
	<div class="dis-row" title="{{general/description}}">{{general/description}}</div>
	<label><?php echo esc_html__( 'Status', 'facetwp-manipulator' ); ?></label>
	<div class="def-row">
		{{#if general/status}}
		<strong style="color:#8bc34a;"><span class="dashicons dashicons-yes"></span> <?php echo esc_html__( 'Enabled', 'facetwp-manipulator' ); ?>
			{{else}}
			<strong style="color:#b71c1c;"><span class="dashicons dashicons-no"></span> <?php echo esc_html__( 'Disabled', 'facetwp-manipulator' ); ?>
				{{/if}}
			</strong>
			<span class="fwpmanip-mute" title="{{#if slack/channel}}{{slack/channel}}{{else}}{{slack/url}}{{/if}}">{{#if slack/channel}}{{slack/channel}}{{else}}{{slack/url}}{{/if}}</span>
	</div>
</div>
<span class="fwpmanip-item-remove" data-confirm="<?php echo esc_attr__( 'Are you sure you want to remove this manipulator?', 'facetwp-manipulator' ); ?>"><?php esc_html_e( 'Delete Manipulator', 'facetwp-manipulator' ); ?></span>
<button type="button" class="fwpmanip-item-edit page-title-action"><?php esc_html_e( 'Edit Manipulator', 'facetwp-manipulator' ); ?></button>
