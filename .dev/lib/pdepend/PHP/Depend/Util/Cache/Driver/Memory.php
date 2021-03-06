<?php
/**
 * This file is part of PHP_Depend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2011, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Util_Cache_Driver
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2011 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://pdepend.org/
 * @since      0.10.0
 */

/**
 * A memory based cache implementation.
 *
 * This class implements the {@link PHP_Depend_Util_Cache_Driver} interface based
 * on an in memory data structure. This means that all cached entries will get
 * lost when the php process exits.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Util_Cache_Driver
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2011 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://pdepend.org/
 * @since      0.10.0
 */
class PHP_Depend_Util_Cache_Driver_Memory implements PHP_Depend_Util_Cache_Driver
{
    /**
     * The type of this class.
     */
    const CLAZZ = __CLASS__;

    /**
     * Default cache entry type.
     */
    const ENTRY_TYPE = 'cache';

    /**
     * The in memory cache.
     *
     * @var array(string=>array)
     */
    protected $cache = array();

    /**
     * Current cache entry type.
     *
     * @var string
     */
    protected $type = self::ENTRY_TYPE;

    /**
     * Sets the type for the next <em>store()</em> or <em>restore()</em> method
     * call. A type is something like a namespace or group for cache entries.
     *
     * Note that the cache type will be reset after each storage method call, so
     * you must invoke right before every call to <em>restore()</em> or
     * <em>store()</em>.
     *
     * @param string $type The name or object type for the next storage method call.
     *
     * @return PHP_Depend_Util_Cache_Driver
     */
    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * This method will store the given <em>$data</em> under <em>$key</em>. This
     * method can be called with a third parameter that will be used as a
     * verification token, when the a cache entry gets restored. If the stored
     * hash and the supplied hash are not identical, that cache entry will be
     * removed and not returned.
     *
     * @param string $key  The cache key for the given data.
     * @param mixed  $data Any data that should be cached.
     * @param string $hash Optional hash that will be used for verification.
     *
     * @return  void
     */
    public function store($key, $data, $hash = null)
    {
        $this->cache[$this->getCacheKey($key)] = array($hash, $data);
    }

    /**
     * This method tries to restore an existing cache entry for the given
     * <em>$key</em>. If a matching entry exists, this method verifies that the
     * given <em>$hash</em> and the the value stored with cache entry are equal.
     * Then it returns the cached entry. Otherwise this method will return
     * <b>NULL</b>.
     *
     * @param string $key  The cache key for the given data.
     * @param string $hash Optional hash that will be used for verification.
     *
     * @return mixed
     */
    public function restore($key, $hash = null)
    {
        $id = $this->getCacheKey($key);
        if (isset($this->cache[$id]) && $this->cache[$id][0] === $hash) {
            return $this->cache[$id][1];
        }
        return null;
    }

    /**
     * This method will remove an existing cache entry for the given identifier.
     * It will delete all cache entries where the cache key start with the given
     * <b>$pattern</b>. If no matching entry exists, this method simply does
     * nothing.
     *
     * @param string $pattern The cache key pattern.
     *
     * @return void
     */
    public function remove($pattern)
    {
        foreach ($this->cache as $key => $value) {
            if (0 === strpos($key, $pattern)) {
                unset($this->cache[$key]);
            }
        }
    }

    /**
     * Creates a prepared cache entry identifier, based on the given <em>$key</em>
     * and the <em>$type</em> property. Note that this method resets the cache
     * type, so that it is only valid for a single call.
     *
     * @param string $key The concrete object key.
     *
     * @return string
     */
    protected function getCacheKey($key)
    {
        $type       = $this->type;
        $this->type = self::ENTRY_TYPE;

        return "{$key}.{$type}";
    }
}