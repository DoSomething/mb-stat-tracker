<?php

/**
 * Basic wrapper of the StatHat API library.
 */

namespace DoSomething\MBStatTracker;

// Load StatHat php library from: https://www.stathat.com/manual/code/php
include 'lib/stathat.php';

class StatHat {

  // The ezkey for the StatHat account.
  private $ezkey;

  // Base name for the stat(s) to be reported.
  private $prefix;

  // Comma-delimited stat names to report to.
  private $statNames;

  /**
   * StatHat constructor.
   *
   * @param string $_ezkey
   *   The ezkey for the StatHat account.
   * @param string $_prefix
   *   The prefix for stat names.
   */
  public function __construct($_ezkey, $_prefix) {
    if (empty($_ezkey)) {
      throw new Exception('No EZ key provided.');
    }
    elseif (empty($_prefix)) {
      throw new Exception('No prefix provided.');
    }

    $ezkey = $_ezkey;

    // The ~ character allows for posting to multiple stats with one call.
    $prefix = $_prefix . '~';
  }

  /**
   * Adds a stat name to report to.
   *
   * @param string $name
   *   The stat name to add to the report.
   */
  public function addStatName($name) {
    // Stat names are comma-delimited.
    $statNames .= $name . ',';
  }

  /**
   * Reports a count to the StatHat API.
   *
   * @param int $count
   *   The count to report.
   */
  public function reportCount($count) {
    $statName = $this->prefix . $this->statNames;
    stathat_ez_count($this->ezkey, $statName, $count);
  }

  /**
   * Reports a value to the StatHat API.
   *
   * @param int $value
   *   The value to report.
   */
  public function reportValue($value) {
    $statName = $this->prefix . $this->statNames;
    stathat_ez_value($this->ezkey, $statName, $value);
  }
}
