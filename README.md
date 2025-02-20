# Newton

A car maintenance company “Newton Car Maintenance” wants to register the maintenance jobs it does on various cars, for various customers.
Some maintenance jobs are specific for a certain brand of car, or even a specific model of a car brand, others apply to all types of 
cars of all cars of a brand/model. Each maintenance job has a fixed rate in terms of service hours and may require certain spare parts.
Spare parts can also be generic for (almost) all cars, others are specific per brand or even per model. E.g., many cars share the same
engine block.

-----

# Setup (with Ddev)
## Git
The Newton project is setup using a main Git repository ([https://github.com/arthurGrinjo/Newton](https://github.com/arthurGrinjo/Newton)).
```
git clone --recursive git@github.com:arthurGrinjo/Newton.git
```
You'll end up with the following directory structure:

```
Newton
└─ .ddev
```

## DDEV
```
~/Newton$ ddev start
~/Newton$ ddev describe
~/Newton$ ddev xdebug on
```
