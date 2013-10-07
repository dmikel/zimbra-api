<?php
/**
 * This file is part of the Zimbra API in PHP library.
 *
 * © Nguyen Van Nguyen <nguyennv1981@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zimbra\Soap\Struct;

use Zimbra\Utils\SimpleXML;

/**
 * QueueQueryField class
 * @package   Zimbra
 * @category  Soap
 * @author    Nguyen Van Nguyen - nguyennv1981@gmail.com
 * @copyright Copyright © 2013 by Nguyen Van Nguyen.
 */
class QueueQueryField
{
    /**
     * Field name
     * @var string
     */
    private $_name;

    /**
     * Match specifications
     * @var array
     */
    private $_matches = array();

    /**
     * Constructor method for QueueQueryField
     * @param  string $name
     * @param  array $matches
     * @return self
     */
    public function __construct($name, array $matches = array())
    {
        $this->_name = trim($name);
        $this->matches($matches);
    }

    /**
     * Gets or sets name
     *
     * @param  string $name
     * @return string|self
     */
    public function name($name = null)
    {
        if(null === $name)
        {
            return $this->_name;
        }
        $this->_name = trim($name);
        return $this;
    }

    /**
     * Add a match
     *
     * @param  ValueAttrib $match
     * @return self
     */
    public function addMatch(ValueAttrib $match)
    {
        $this->_matches[] = $match;
        return $this;
    }

    /**
     * Gets or sets matches array
     *
     * @param  array $matches
     * @return array|self
     */
    public function matches(array $matches = null)
    {
        if(null === $matches)
        {
            return $this->_matches;
        }
        $this->_matches = array();
        foreach ($matches as $match)
        {
            if($match instanceof ValueAttrib)
            {
                $this->_matches[] = $match;
            }
        }
        return $this;
    }

    /**
     * Returns the array representation of this class 
     *
     * @param  string $name
     * @return array
     */
    public function toArray($name = 'field')
    {
        $name = !empty($name) ? $name : 'field';
        $arr = array(
            'name' => $this->_name,
        );
        if(count($this->_matches))
        {
            $arr['match'] = array();
            foreach ($this->_matches as $match)
            {
                $matchArr = $match->toArray('match');
                $arr['match'][] = $matchArr['match'];
            }
        }
        return array($name => $arr);
    }

    /**
     * Method returning the xml representation of this class
     *
     * @param  string $name
     * @return SimpleXML
     */
    public function toXml($name = 'field')
    {
        $name = !empty($name) ? $name : 'field';
        $xml = new SimpleXML('<'.$name.' />');
        $xml->addAttribute('name', $this->_name);
        foreach ($this->_matches as $match)
        {
            $xml->append($match->toXml('match'));
        }
        return $xml;
    }

    /**
     * Method returning the xml string representation of this class
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toXml()->asXml();
    }
}