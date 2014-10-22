<?php

namespace Sabre\HTTP\BC;

use Sabre\HTTP\Stream;

/**
 * This trait adds backwards-compatiblity features for both Message objects.
 *
 * Both the Request and the Response objects are examples of Message objects.
 */
trait MessageTrait {

    /**
     * Returns the body as a readable stream resource.
     *
     * Note that the stream may not be rewindable, and therefore may only be
     * read once.
     *
     * @return resource
     */
    function getBodyAsStream() {

        $body = $this->getBody();
        if ($body) {
            return $body->detach();
        } else {
            return fopen('php://memory','r+');
        }

    }

    /**
     * Returns the body as a string.
     *
     * Note that because the underlying data may be based on a stream, this
     * method could only work correctly the first time.
     *
     * @return string
     */
    function getBodyAsString() {

        $body = $this->getBody();
        if ($body) {
            $contents = $body->getContents();
            $this->setBody(new Stream($contents));
            return $contents;
        } else {
            return '';
        }

    }

    /**
     * Adds a new set of HTTP headers.
     *
     * Any existing headers will not be overwritten.
     *
     * @param array $headers
     * @return void
     */
    function addHeaders(array $headers) {

        foreach($headers as $name => $value) {
            $this->addHeader($name, $value);
        }

    }

    /**
     * Sets a new set of HTTP headers.
     *
     * The headers array should contain headernames for keys, and their value
     * should be specified as either a string or an array.
     *
     * Any header that already existed will be overwritten.
     *
     * @param array $headers
     * @return void
     */
    function setHeaders(array $headers) {

        foreach($headers as $name => $value) {
            $this->setHeader($name, $value);
        }

    }

    /**
     * Sets the HTTP version.
     *
     * Should be 1.0 or 1.1.
     *
     * @param string $version
     * @return void
     */
    function setHttpVersion($version) {

        $this->setProtocolVersion($version);

    }

    /**
     * Returns the HTTP version.
     *
     * @return string
     */
    function getHttpVersion() {

        return $this->getProtocolVersion($version);

    }

}