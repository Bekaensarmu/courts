<?php

namespace PHPMaker2024\project2;

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(53, "mi_Dashboard1", $Language->menuPhrase("53", "MenuText"), "Dashboard1", -1, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}Dashboard1'), false, false, "", "", false, true);
$sideMenu->addMenuItem(13, "mci_የተጠቃሚዎች_ዝርዝር", $Language->menuPhrase("13", "MenuText"), "", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(11, "mi_users", $Language->menuPhrase("11", "MenuText"), "UsersList", 13, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}users'), false, false, "", "", false, true);
$sideMenu->addMenuItem(15, "mci_ወታደራዊ_ፍርድ_ቤት", $Language->menuPhrase("15", "MenuText"), "", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(46, "mi_specialfiles", $Language->menuPhrase("46", "MenuText"), "SpecialfilesList", 15, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}specialfiles'), false, false, "", "", false, true);
$sideMenu->addMenuItem(6, "mi_courts", $Language->menuPhrase("6", "MenuText"), "CourtsList", 15, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}courts'), false, false, "", "", false, true);
$sideMenu->addMenuItem(2, "mi_attorneys", $Language->menuPhrase("2", "MenuText"), "AttorneysList", 15, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}attorneys'), false, false, "", "", false, true);
$sideMenu->addMenuItem(8, "mi_judges", $Language->menuPhrase("8", "MenuText"), "JudgesList", 15, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}judges'), false, false, "", "", false, true);
$sideMenu->addMenuItem(3, "mi_bars", $Language->menuPhrase("3", "MenuText"), "BarsList", 15, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}bars'), false, false, "", "", false, true);
$sideMenu->addMenuItem(16, "mci_የፍርድ_ቤት_መዝገብ", $Language->menuPhrase("16", "MenuText"), "", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(5, "mi_case_hears", $Language->menuPhrase("5", "MenuText"), "CaseHearsList", 16, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}case_hears'), false, false, "", "", false, true);
$sideMenu->addMenuItem(7, "mi_decisions", $Language->menuPhrase("7", "MenuText"), "DecisionsList", 16, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}decisions'), false, false, "", "", false, true);
$sideMenu->addMenuItem(45, "mi_appeal", $Language->menuPhrase("45", "MenuText"), "AppealList", 16, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}appeal'), false, false, "", "", false, true);
$sideMenu->addMenuItem(33, "mci_ሪፖርት", $Language->menuPhrase("33", "MenuText"), "", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(47, "mi_Report2", $Language->menuPhrase("47", "MenuText"), "Report2", 33, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}Report2'), false, false, "", "", false, true);
$sideMenu->addMenuItem(48, "mi_Report3", $Language->menuPhrase("48", "MenuText"), "Report3", 33, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}Report3'), false, false, "", "", false, true);
$sideMenu->addMenuItem(49, "mi_Report4", $Language->menuPhrase("49", "MenuText"), "Report4", 33, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}Report4'), false, false, "", "", false, true);
$sideMenu->addMenuItem(50, "mi_Report5", $Language->menuPhrase("50", "MenuText"), "Report5", 33, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}Report5'), false, false, "", "", false, true);
$sideMenu->addMenuItem(51, "mi_Report6", $Language->menuPhrase("51", "MenuText"), "Report6", 33, "", AllowListMenu('{5C70C1A0-7BD3-4BBB-9481-D6DD6DAF2CDC}Report6'), false, false, "", "", false, true);
echo $sideMenu->toScript();
