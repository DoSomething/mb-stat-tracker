This library offers an interface to interact with the various stat tracking tools that we will be using with the message broker.

## Add via Composer
Add to a project through Composer in the composer.json:  
```
{
  "require": {
    "dosomething/mb-stat-tracker": "v0.0.2"
  }
}
```  

## StatHat - Usage
StatHat basic value tracking that can either be incremented as a counter or averaged over time.

#### Create the StatHat Object
* The `$stathat_ez_key` is the EZ key linked to your StatHat account.
* The second parameter of the constructor (in this case `'stat-name-base:'`)is the base name of the stat. If no subset stat is defined, then stats will just get reported to this stat name alone.
* The ':' at the end of the stat's base name is not required. But it is a convention we're going with on the message broker.
```
use DoSomething\MBStatTracker\StatHat;

$statHat = new StatHat($stathat_ez_key, 'stat-name-base:');
```

#### Enable for Production
Maybe this is a bad design decision, but by default, stats won't get reported to the StatHat servers. This was done so dev stats don't mix with production stats. Again, maybe a bad design decision. But for now, you'll have to explicitly enable it if you want stats reported.
```
$statHat->setIsProduction(TRUE);
```

#### Add Additional Stats
(optional) If necessary, secondary stat names can be reported to and will be grouped separately in the StatHat reports. The following would create 3 separate stat names `stat-name-base: stat name 1`, `stat-name-base: stat name 2`, and `stat-name-base: stat name 3`:
```
$statHat->addStatName('stat name 1');
$statHat->addStatName('stat name 2');
$statHat->addStatName('stat name 3');
```

#### Report the Stats
Only one of the following should be used for each stat name:

* Add `$count` to the value of a stat name:
```
$statHat->reportCount($count);
```

* Add `$value` to a stat name. StatHat will calculate the average:
```
$statHat->reportValue($value);
```

#### Report Different Stats
To report different stats to different stat names, create different instances of the StatHat object.
```
$sh1A = new StatHat($ez_key, 'stat-base-1');
$sh1A->addStatName('name A');
$sh1A->reportCount(1);

$sh1B = new StatHat($ez_key, 'stat-base-1');
$sh1B->addStatName('name B');
$sh1B->reportCount(2);

$sh2 = new StatHat($ez_key, 'stat-base-2');
$sh2->addStatName('name name name');
$sh2->reportValue(1);
```

## StatHat - Checking Reports
After logging into the StatHat account, reported stats can be viewed here: https://www.stathat.com/v/stats