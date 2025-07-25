<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) 2015 ATM Consulting <support@atm-consulting.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * 	\file		admin/abricot_setup.php
 * 	\ingroup	abricot
 * 	\brief		This file is an example module setup page
 * 			Put some comments here
 */

// Dolibarr environment
$res = @include("../../main.inc.php"); 		// From htdocs directory
if (! $res) {
    $res = @include("../../../main.inc.php"); 	// From "custom" directory
}

// Libraries
require_once DOL_DOCUMENT_ROOT . "/core/lib/admin.lib.php";
// Translations
$langs->load("abricot@abricot");

// Access control
if (! $user->admin) {
    accessforbidden();
}

// Parameters
$action = GETPOST('action', 'alpha');

/*
 * Actions
 */

if (preg_match('/set_(.*)/',$action,$reg))
{
	$code=$reg[1];
	if (dolibarr_set_const($db, $code, GETPOST($code, 'alphanohtml'), 'chaine', 0, '', $conf->entity) > 0)
	{
		header("Location: ".$_SERVER["PHP_SELF"]);
		exit;
	}
	else
	{
		dol_print_error($db);
	}
}

if (preg_match('/del_(.*)/',$action,$reg))
{
	$code=$reg[1];
	if (dolibarr_del_const($db, $code, 0) > 0)
	{
		header("Location: ".$_SERVER["PHP_SELF"]);
		exit;
	}
	else
	{
		dol_print_error($db);
	}
}


/*
 * View
 */

$page_name = "Setup";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php">'
    . $langs->trans("BackToModuleList") . '</a>';
print_fiche_titre($langs->trans($page_name), $linkback);

// Configuration header
dol_fiche_head(
    $head,
    'settings',
    'Abricot',
    0,
    "abricot@abricot"
);

// Setup page goes here
$form=new Form($db);
$var=false;
print '<table class="noborder" width="100%">';
print '<tbody>';
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("Settings").'</td>'."\n";
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="center" width="100">'.$langs->trans("Value").'</td></tr>'."\n";

$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("set_ABRICOT_USE_OLD_DATABASE_ENCODING_SETTING").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="center" width="100">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'. newToken() .'">';
print '<input type="hidden" name="action" value="set_ABRICOT_USE_OLD_DATABASE_ENCODING_SETTING">';
echo ajax_constantonoff('ABRICOT_USE_OLD_DATABASE_ENCODING_SETTING');
print '</form>';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("set_ABRICOT_USE_OLD_EMPTY_DATE_FORMAT").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="center" width="100">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'. newToken() .'">';
print '<input type="hidden" name="action" value="set_ABRICOT_USE_OLD_EMPTY_DATE_FORMAT">';
echo ajax_constantonoff('ABRICOT_USE_OLD_EMPTY_DATE_FORMAT');
print '</form>';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("set_ABRICOT_WKHTMLTOPDF_CMD").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="right" width="300" style="white-space:nowrap;">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'. newToken() .'">';
print '<input type="hidden" name="action" value="set_ABRICOT_WKHTMLTOPDF_CMD">';
print '<input type="text" name="ABRICOT_WKHTMLTOPDF_CMD" value="'.(getDolGlobalString('ABRICOT_WKHTMLTOPDF_CMD') ? '' : getDolGlobalString('ABRICOT_WKHTMLTOPDF_CMD')).'" size="80" placeholder="wkhtmltopdf" />';
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</form>';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("set_ABRICOT_CONVERTPDF_CMD").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="right" width="300" style="white-space:nowrap;">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'. newToken() .'">';
print '<input type="hidden" name="action" value="set_ABRICOT_CONVERTPDF_CMD">';
print '<input type="text" name="ABRICOT_CONVERTPDF_CMD" value="'.(!getDolGlobalString('ABRICOT_CONVERTPDF_CMD') ? '' : getDolGlobalString('ABRICOT_CONVERTPDF_CMD')).'" size="80" placeholder="libreoffice --invisible --norestore --headless --convert-to pdf --outdir " />';
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</form>';
print '</td></tr>';

print '<tbody>';
print '</table><br>';

$form=new Form($db);
$var=false;
print '<table class="noborder" width="100%">';
print '<tbody>';
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("Migration").'</td>'."\n";
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="center" width="100">'.$langs->trans("Action").'</td></tr>'."\n";

$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("MIGRATE_DATETIME_DEFAULT_TO_NULL").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="center" width="100">';
print '<a class="butAction" href="../script/change-datetime-default-to-null.php">' . $langs->trans("Migrate") . '</a>';
print '</form>';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("ABRICOT_MAILS_FORMAT").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="center" width="200">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="action" value="set_ABRICOT_MAILS_FORMAT">';
print '<input type="hidden" name="token" value="'. newToken() .'">';
print $form->selectarray('ABRICOT_MAILS_FORMAT',array('iso-8859-1'=>'iso-8859-1', 'UTF-8'=>'UTF-8'), getDolGlobalString('ABRICOT_MAILS_FORMAT'));
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</form>';
print '</td></tr>';

print '<tbody>';
print '</table>';

llxFooter();

$db->close();
