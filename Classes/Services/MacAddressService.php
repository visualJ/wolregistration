<?php
/**
 * Created by PhpStorm.
 * User: benedikt.ringlein
 * Date: 14.04.2016
 * Time: 09:16
 */

namespace BenediktRinglein\Wolregistration\Services;

/**
 * Class MacAddressService
 *
 * A mac address service implementation for linux
 *
 * @package BenediktRinglein\Wolregistration\Services
 */
class MacAddressService
{
	/**
	 * Retrieves the clients physical address. The clients has to be
	 * on the same ethernet segment for this to work. Also, this is optimized for a Linux environment.
	 * To work on Windows, some changes have to be made (like using arp -a and $cols[1]).
	 * @return string the clients mac address, if available, otherwise false
	 */
	public function getClientMacAddress()
	{
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$macAddr = false;

		#run the external command, break output into lines
		$arp = `arp -n $ipAddress`;
		$lines = explode("\n", $arp);

		#look for the output line describing our IP address
		foreach ($lines as $line) {
			$cols = preg_split('/\s+/', trim($line));
			if ($cols[0] == $ipAddress) {
				$macAddr = $cols[2];
				break;
			}
		}

		return $macAddr;
	}
}