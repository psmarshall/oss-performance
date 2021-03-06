<?hh
/*
 *  Copyright (c) 2014, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree. An additional grant
 *  of patent rights can be found in the PATENTS file in the same directory.
 *
 */

final class Laravel5Target extends PerfTarget {
  public function __construct(
    private PerfOptions $options,
  ) {
  }

  protected function getSanityCheckString(): string {
    return 'Laravel 5';
  }

  public function install(): void {
    $src_dir = $this->options->srcDir;
    if ($src_dir) {
      Utils::CopyDirContents(
        $src_dir,
        $this->getSourceRoot(),
      );
    } else {
      shell_exec($this->safeCommand(Vector {
        'tar',
        '-C', $this->options->tempDir,
        '-zxf',
        __DIR__.'/laravel-5.0.22.tar.gz'
      }));
      shell_exec($this->safeCommand(Vector {
        'tar',
        '-C', $this->options->tempDir.'/laravel-5.0.22',
        '-jxf',
        __DIR__.'/vendor.tar.bz2'
      }));
    }

  }

  public function getSourceRoot(): string {
    return $this->options->tempDir.'/laravel-5.0.22/public';
  }
}
