{*
 * 2016 Michael Dekker
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@michaeldekker.com so we can send you a copy immediately.
 *
 *  @author    Michael Dekker <prestashop@michaeldekker.com>
 *  @copyright 2016 Michael Dekker
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *
*}
{if $smarty.const._PS_VERSION_|@addcslashes:'\'' < '1.6'}
	<fieldset>
		<legend>{l s='SwiftMailer upgrader' mod='swiftupgrader'}</legend>
		<p>
			<strong>{l s='This module upgrade your version of SwiftMailer' mod='swiftupgrader'}</strong><br />
			{l s='Currently installed version:' mod='swiftupgrader'}<br />
		</p>
		<ul>
			<li>{l s='SwiftMailer 5.4.1' mod='swiftupgrader'}</li>
		</ul>
		<p>
			{l s='If you do not see any error messages on this page, then you have successfully installed the module' mod='swiftupgrader'}
		</p>
	</fieldset>
	<br />
{else}
	<div class="panel">
		<h3><i class="icon icon-email"></i> {l s='SwiftMailer upgrader' mod='swiftupgrader'}</h3>
		<p>
			<strong>{l s='This module upgrade your version of SwiftMailer' mod='swiftupgrader'}</strong><br />
			{l s='Currently installed version:' mod='swiftupgrader'}<br />
		</p>
		<ul>
			<li>{l s='SwiftMailer 5.4.1' mod='swiftupgrader'}</li>
		</ul>
		<p>
			{l s='If you do not see any error messages on this page, then you have successfully installed the module' mod='swiftupgrader'}
		</p>
	</div>
{/if}