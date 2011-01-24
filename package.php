#!/usr/bin/env php
<?php

$name          = 'AuthorizeNet';
$summary       = 'Authorize.net AMI API SDK';
$lead          = 'Michael Gauthier';
$leadUser      = 'gauthierm';
$leadEmail     = 'mike@silverorange.com';
$date          = date('Y-m-d');
$version       = '1.1.1';
$stability     = 'stable';
$license       = 'Authorize.net SDK License Agreement (included)';
$notes         = 'Pear package of provided SDK.';
$minPHPVersion = '5.2.1';
$channel       = 'pear.silverorange.com';
$description   = <<<TEXT
Authorize.net Advanced Integration Method API allows you to process online
payments.
TEXT;

/* This function is intended to generate the full file list */
function parsePath($fullPath, $role, $fileMatch = '/^(.*)$/', $padding = 3)
{
	$fileList = '';

	$file = basename($fullPath);
	if (is_dir($fullPath)) {
		$fileList .= str_repeat("\t", $padding) . "<dir name=\"{$file}\">\n";
		foreach (scandir($fullPath) as $subPath) {
			if ($subPath === '.' || $subPath === '..') {
				continue;
			}
			$fileList .= parsePath(
				$fullPath . '/' . $subPath,
				$role,
				$fileMatch,
				$padding + 1
			);
		}
		$fileList .= str_repeat("\t", $padding) . "</dir><!-- {$file} -->\n";
	} elseif (is_file($fullPath)) {
		if (preg_match($fileMatch, $file)) {
			$fileList .= str_repeat("\t", $padding)
				. "<file name=\"{$file}\" role=\"{$role}\" />\n";
		}
	}

	return $fileList;

}

$rootDir = realpath(dirname(__FILE__) . '/');
$fileList  = parsePath($rootDir . '/lib', 'php', '/^(.*)(\.php|\.pem|README)$/');
$fileList .= parsePath($rootDir . '/doc', 'doc');
$fileList .= parsePath($rootDir . '/tests', 'test', '/^(.*)\.(php|xml)$/');
$fileList .= parsePath($rootDir . '/README', 'doc');
$fileList .= parsePath($rootDir . '/License.pdf', 'doc');

// Lastly the install-list
$directory = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator(
		$rootDir . '/lib'
	)
);

$installList = '';
foreach ($directory as $path) {
	$basePath = trim(substr($path, strlen($rootDir)), '/');

	// This just takes the 'lib/' off every path name, so it will be
	// installed in the correct location
	$installList .= '			<install name="'
		. $basePath
		. '" as="AuthorizeNet/'
		. substr($basePath, 4)
		. "\" />\n";
}

$package = <<<XML
<?xml version="1.0"?>
<package version="2.0"
	xmlns="http://pear.php.net/dtd/package-2.0">

	<name>{$name}</name>
	<channel>{$channel}</channel>
	<summary>{$summary}</summary>
	<description>{$description}</description>
	<lead>
		<name>{$lead}</name>
		<user>{$leadUser}</user>
		<email>{$leadEmail}</email>
		<active>true</active>
	</lead>
	<date>{$date}</date>
	<version>
		<release>{$version}</release>
		<api>{$version}</api>
	</version>
	<stability>
		<release>{$stability}</release>
		<api>{$stability}</api>
	</stability>
	<license>{$license}</license>
	<notes>{$notes}</notes>
	<contents>
		<dir name="/">
{$fileList}		</dir>
	</contents>
	<dependencies>
		<required>
			<php>
				<min>{$minPHPVersion}</min>
			</php>
			<pearinstaller>
				<min>1.4</min>
			</pearinstaller>
		</required>
	</dependencies>
	<phprelease>
		<filelist>
{$installList}		</filelist>
	</phprelease>
</package>
XML;

if (isset($argv) && in_array('make', $argv)) {
	file_put_contents('package.xml', $package);
} else {
	echo $package;
}
